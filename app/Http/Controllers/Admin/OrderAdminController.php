<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDeliveryFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class OrderAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Orders/Index', [
            'orders' => Order::query()->with(['customer','vendor'])->latest()->paginate(20),
        ]);
    }

    public function show(Order $order): Response
    {
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order->load(['items.product','requiredData','deliveries.files']),
        ]);
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
}
