<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VendorProfile;
use App\Models\VendorTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class VendorAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $vendorsQuery = User::query()
            ->role('Vendor')
            ->with('vendorProfile')
            ->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $vendorsQuery->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('vendorProfile', function ($profileQuery) use ($search) {
                        $profileQuery->where('store_name', 'like', "%{$search}%");
                    });
            });
        }

        $availableUsersQuery = User::query()
            ->whereDoesntHave('roles', function ($builder) {
                $builder->where('name', 'Vendor');
            })
            ->orderBy('name');

        if ($request->filled('user_q')) {
            $search = $request->string('user_q')->toString();
            $availableUsersQuery->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Admin/Vendors/Index', [
            'vendors' => $vendorsQuery->paginate(20)->withQueryString(),
            'availableUsers' => $availableUsersQuery->limit(10)->get(['id', 'name', 'email']),
            'filters' => $request->only('q', 'user_q'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'store_name' => ['required', 'string', 'max:150'],
            'nid' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'payout_info' => ['nullable', 'json'],
            'documents' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        $user = User::findOrFail($data['user_id']);

        if ($user->hasRole('Vendor')) {
            return back()->with('error', 'User is already a vendor.');
        }

        $logoPath = $request->file('logo')?->store('vendors', 'public');

        DB::transaction(function () use ($user, $data, $logoPath) {
            $user->assignRole('Vendor');

            VendorProfile::create([
                'user_id' => $user->id,
                'store_name' => $data['store_name'],
                'nid' => $data['nid'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'balance' => $data['balance'] ?? 0,
                'payout_info' => $data['payout_info'] ? json_decode($data['payout_info'], true) : null,
                'documents' => $this->normalizeDocuments($data['documents'] ?? null),
                'logo_path' => $logoPath,
            ]);
        });

        return back()->with('success', 'Vendor created');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required','in:active,banned'],
        ]);
        $user->update(['status' => $data['status']]);
        return back()->with('success','Vendor updated');
    }

    public function show(User $user): Response
    {
        $user->load(['vendorProfile', 'products', 'ordersAsVendor']);

        $transactions = VendorTransaction::query()
            ->whereHas('vendorProfile', function ($builder) use ($user) {
                $builder->where('user_id', $user->id);
            })
            ->with('creator')
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Vendors/Show', [
            'vendor' => $user,
            'vendorProfile' => $user->vendorProfile,
            'products' => $user->products()->latest()->limit(10)->get(),
            'orders' => $user->ordersAsVendor()->latest()->limit(10)->get(),
            'transactions' => $transactions,
        ]);
    }

    public function edit(User $user): Response
    {
        $user->load('vendorProfile');

        return Inertia::render('Admin/Vendors/Edit', [
            'vendor' => $user,
            'vendorProfile' => $user->vendorProfile,
        ]);
    }

    public function updateProfile(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:150'],
            'nid' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'payout_info' => ['nullable', 'json'],
            'documents' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        $profile = $user->vendorProfile;

        if (!$profile) {
            return back()->with('error', 'Vendor profile not found.');
        }

        $logoPath = $profile->logo_path;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('vendors', 'public');
        }

        $profile->update([
            'store_name' => $data['store_name'],
            'nid' => $data['nid'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'balance' => $data['balance'] ?? $profile->balance,
            'payout_info' => $data['payout_info'] ? json_decode($data['payout_info'], true) : null,
            'documents' => $this->normalizeDocuments($data['documents'] ?? null),
            'logo_path' => $logoPath,
        ]);

        return back()->with('success', 'Vendor profile updated');
    }

    public function destroyProfile(User $user): RedirectResponse
    {
        $profile = $user->vendorProfile;

        if ($profile) {
            $profile->delete();
        }

        return back()->with('success', 'Vendor profile removed');
    }

    public function ban(User $user): RedirectResponse
    {
        $user->update(['status' => 'banned']);
        return back()->with('success','Vendor banned');
    }

    public function unban(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);
        return back()->with('success','Vendor unbanned');
    }

    private function normalizeDocuments(?string $documents): array
    {
        if (!$documents) {
            return [];
        }

        return collect(preg_split('/\r?\n|,/', $documents))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
