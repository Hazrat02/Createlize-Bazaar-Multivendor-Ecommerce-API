<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDeliveryFile;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class OrderAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Order::query()->with(['customer','vendor'])->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('order_number', 'like', "%{$search}%")
                    ->orWhere('payment_invoice_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $query->paginate(20)->withQueryString(),
            'filters' => $request->only('q'),
        ]);
    }

    public function show(Order $order): Response
    {
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order->load(['customer','vendor','items.product','requiredData','deliveries.files']),
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'order_status' => ['required','in:processing,delivered,canceled'],
            'payment_status' => ['required','in:pending,paid,unpaid,failed'],
        ]);

        $order->update($data);

        return back()->with('success', 'Order updated');
    }

    public function uploadDeliveryFile(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'file' => ['required','file','max:51200'],
            'label' => ['nullable','string','max:150'],
        ]);

        $path = $data['file']->store('order-deliveries/'.$order->id, 'private');

        $delivery = $order->deliveries()->firstOrCreate([
            'status' => 'uploaded',
        ]);

        $delivery->files()->create([
            'path' => $path,
            'original_name' => $data['file']->getClientOriginalName(),
            'mime' => $data['file']->getClientMimeType(),
            'size' => $data['file']->getSize(),
            'label' => $data['label'] ?? null,
        ]);

        return back()->with('success','Delivery file uploaded');
    }

    public function invoice(Order $order)
    {
        $template = Setting::query()->where('key', 'invoice.template')->first()?->value ?? [];

        return response()->view('admin.invoice', [
            'order' => $order->load(['customer','vendor','items.product']),
            'template' => $template,
        ]);
    }
}
