<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Services\Payments\UddoktaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentCallbackController extends Controller
{
    public function success(Request $request, UddoktaPayService $uddoktaPay)
    {
        $invoiceId = (string)$request->input('invoice_id', $request->input('invoice', ''));

        if (!$invoiceId) {
            return response()->view('payment.failed', [
                'message' => 'Missing invoice ID.',
            ]);
        }

        try {
            $verification = $uddoktaPay->verifyPayment($invoiceId);
        } catch (\Throwable $e) {
            return response()->view('payment.failed', [
                'message' => 'Payment verification failed.',
            ]);
        }

        $statusValue = strtoupper((string) data_get($verification, 'data.status', data_get($verification, 'status', '')));
        $isCompleted = in_array($statusValue, ['COMPLETED', 'PAID', 'SUCCESS'], true);

        $order = Order::query()->where('payment_invoice_id', $invoiceId)->first();

        if ($order && $isCompleted && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => $order->order_status === 'created' ? 'processing' : $order->order_status,
                'payment_method' => $order->payment_method ?: 'uddoktapay',
            ]);

            $this->sendInvoiceEmail($order->load(['customer','items.product','vendor']));
        }

        return response()->view('payment.success', [
            'order' => $order,
            'isCompleted' => $isCompleted,
        ]);
    }

    public function cancel()
    {
        return response()->view('payment.cancel');
    }

    private function sendInvoiceEmail(Order $order): void
    {
        $customer = $order->customer;
        if (!$customer || !$customer->email) {
            return;
        }

        $this->applySmtpSettings();

        $template = Setting::query()->where('key', 'invoice.template')->first()?->value ?? [];
        $subject = $template['email_subject'] ?? ('Invoice #' . ($order->order_number ?? $order->id));

        Mail::send('emails.invoice', [
            'order' => $order,
            'template' => $template,
        ], function ($mail) use ($customer, $subject) {
            $mail->to($customer->email)
                ->subject(Str::limit($subject, 150));
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
