<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VendorAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Vendors/Index', [
            'vendors' => User::query()->role('Vendor')->with('vendorProfile')->latest()->paginate(20),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required','in:active,banned'],
        ]);
        $user->update(['status' => $data['status']]);
        return back()->with('success','Vendor updated');
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
}
