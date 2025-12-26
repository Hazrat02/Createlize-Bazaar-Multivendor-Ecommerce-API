<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDeliveryFile;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\Orders\CheckoutService;
use App\Services\Orders\RequiredFieldsBuilder;
use App\Services\Settings\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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

        $wasDelivered = $order->order_status === 'delivered';
        $order->update($data);

        if (!$wasDelivered && $data['order_status'] === 'delivered') {
            $this->sendInvoiceEmail($order->load(['customer','items.product','vendor']));
        }

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

    public function demoCreate(): Response
    {
        $users = User::query()
            ->role('Customer')
            ->orderBy('name')
            ->get(['id','name','email']);

        $products = Product::query()
            ->where('is_active', true)
            ->with('vendor:id,name')
            ->orderByDesc('id')
            ->get(['id','name','title','vendor_id','price','discount_percent','currency'])
            ->map(function (Product $product) {
                $name = $product->title ?: $product->name;
                $vendor = $product->vendor?->name ?? 'Vendor';
                $product->display_name = "{$name} ({$vendor})";
                return $product;
            });

        return Inertia::render('Admin/Orders/DemoCreate', [
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function demoStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required','integer','exists:users,id'],
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
        ]);

        $request->session()->put('demo_order', [
            'user_id' => (int)$data['user_id'],
            'product_id' => (int)$data['product_id'],
            'qty' => (int)$data['qty'],
        ]);

        return redirect()->route('admin.orders.demo.checkout');
    }

    public function demoCheckout(
        Request $request,
        RequiredFieldsBuilder $fieldsBuilder,
        SettingsService $settings
    ): RedirectResponse|Response {
        $demo = $request->session()->get('demo_order');
        if (!$demo) {
            return redirect()->route('admin.orders.demo.create')
                ->with('error', 'Demo order not found. Please start again.');
        }

        $user = User::query()->findOrFail((int)$demo['user_id']);
        $product = Product::query()->with('deliveryType')->findOrFail((int)$demo['product_id']);

        $requiredFields = $fieldsBuilder->build($product);
        $paymentMode = (string)$settings->get('payment_uddoktapay', 'mode', 'sandbox');
        $paymentMethod = ($product->deliveryType?->key === 'cod') ? 'cod' : 'uddoktapay';

        $unitPrice = (float)$product->final_price;
        $qty = (int)$demo['qty'];
        $total = round($unitPrice * $qty, 2);

        $product->display_name = $product->title ?: $product->name;

        return Inertia::render('Admin/Orders/DemoCheckout', [
            'user' => $user->only(['id','name','email']),
            'product' => [
                'id' => $product->id,
                'display_name' => $product->display_name,
                'currency' => $product->currency,
                'unit_price' => $unitPrice,
            ],
            'qty' => $qty,
            'total' => $total,
            'requiredFields' => $requiredFields,
            'paymentMode' => $paymentMode,
            'paymentMethod' => $paymentMethod,
        ]);
    }

    public function demoCheckoutSubmit(
        Request $request,
        CartService $cart,
        RequiredFieldsBuilder $fieldsBuilder,
        CheckoutService $checkout
    ): RedirectResponse|HttpResponse {
        $demo = $request->session()->get('demo_order');
        if (!$demo) {
            return redirect()->route('admin.orders.demo.create')
                ->with('error', 'Demo order not found. Please start again.');
        }

        $user = User::query()->findOrFail((int)$demo['user_id']);
        $product = Product::query()->with('deliveryType')->findOrFail((int)$demo['product_id']);
        $requiredFields = $fieldsBuilder->build($product);

        $requiredData = (array)$request->input('required_data', []);
        $couponCode = $request->input('coupon_code');
        $fileUploads = [];

        foreach ($requiredFields as $field) {
            if (($field['type'] ?? '') !== 'file') {
                continue;
            }

            $fieldName = $field['name'];
            $fileKey = "required_data.$fieldName";
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $path = $file->store('order-required', 'private');
                $fileUploads[$fieldName] = [
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ];
                $requiredData[$fieldName] = $file->getClientOriginalName();
            }
        }

        $cart->clear();
        $cart->add($product->id, (int)$demo['qty']);

        $appUrl = $request->getSchemeAndHttpHost();

        try {
            $result = $checkout->checkout($user, [
                'required_data' => $requiredData,
                'coupon_code' => $couponCode ?: null,
                'redirect_url' => $appUrl,
                'cancel_url' => $appUrl,
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        $orderNumber = $result['order_number'] ?? null;
        if ($orderNumber && !empty($fileUploads)) {
            $order = Order::query()->where('order_number', $orderNumber)->first();
            if ($order) {
                foreach ($fileUploads as $fieldName => $fileInfo) {
                    $order->requiredData()
                        ->where('field_name', $fieldName)
                        ->update([
                            'file_path' => $fileInfo['path'],
                            'value' => $fileInfo['original_name'],
                        ]);
                }
            }
        }

        $request->session()->put('demo_order_last', [
            'order_number' => $orderNumber,
        ]);

        $payment = $result['payment'] ?? [];
        $paymentUrl = $payment['payment_url'] ?? null;
        if ($paymentUrl) {
            return Inertia::location($paymentUrl);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Demo order created.');
    }

    private function sendInvoiceEmail(Order $order): void
    {
        $customer = $order->customer;
        if (!$customer || !$customer->email) {
            return;
        }

        $this->applySmtpSettings();

        $template = Setting::query()->where('key', 'invoice.template')->first()?->value ?? [];
        $smtpTemplate = Setting::query()->where('key', 'smtp')->first()?->value ?? [];
        $subjectBase = 'Invoice #' . ($order->order_number ?? $order->id);
        $subjectTemplate = $smtpTemplate['template_subject'] ?? null;
        $bodyTemplate = $smtpTemplate['template_body'] ?? null;
        $invoiceHtml = view('emails.invoice-fragment', [
            'order' => $order,
            'template' => $template,
        ])->render();

        $replace = [
            '{{order_number}}' => $order->order_number ?? (string)$order->id,
            '{{customer_name}}' => $customer->name ?? '',
            '{{customer_email}}' => $customer->email ?? '',
            '{{total}}' => number_format((float)($order->total ?? 0), 2),
            '{{date}}' => $order->created_at?->format('Y-m-d') ?? '',
            '{{name}}' => $customer->name ?? '',
            '{{email}}' => $customer->email ?? '',
            '{{subject}}' => $subjectBase,
            '{{invoice_html}}' => $invoiceHtml,
        ];

        if ($bodyTemplate) {
            $subject = $subjectTemplate ? strtr($subjectTemplate, $replace) : $subjectBase;

            $marker = '__INVOICE_MESSAGE__';
            $body = strtr($bodyTemplate, array_merge($replace, ['{{message}}' => $marker]));
            $body = preg_replace('#<p[^>]*>\s*' . preg_quote($marker, '#') . '\s*</p>#i', $marker, $body);
            $body = str_replace($marker, $invoiceHtml, $body);

            if (!str_contains($bodyTemplate, '{{message}}') && !str_contains($bodyTemplate, '{{invoice_html}}')) {
                $body .= $invoiceHtml;
            }

            Mail::send([], [], function ($mail) use ($customer, $subject, $body) {
                $mail->to($customer->email)
                    ->subject(Str::limit($subject, 150))
                    ->html($body);
            });
            return;
        }

        Mail::send('emails.invoice', [
            'order' => $order,
            'template' => $template,
        ], function ($mail) use ($customer, $subjectBase) {
            $mail->to($customer->email)
                ->subject(Str::limit($subjectBase, 150));
        });
    }

    private function applySmtpSettings(): void
    {
        $smtp = Setting::query()->where('key', 'smtp')->first()?->value;
        if (!$smtp) {
            return;
        }

        config()->set('mail.default', $smtp['mailer'] ?? 'smtp');
        config()->set('mail.mailers.smtp.host', $smtp['host'] ?? '');
        config()->set('mail.mailers.smtp.port', $smtp['port'] ?? 587);
        config()->set('mail.mailers.smtp.username', $smtp['username'] ?? null);
        config()->set('mail.mailers.smtp.password', $smtp['password'] ?? null);
        config()->set('mail.mailers.smtp.encryption', $smtp['encryption'] ?? null);
        config()->set('mail.from.address', $smtp['from_address'] ?? 'no-reply@example.com');
        config()->set('mail.from.name', $smtp['from_name'] ?? 'Admin');
    }
}
