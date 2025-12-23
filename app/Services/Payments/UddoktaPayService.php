<?php

namespace App\Services\Payments;

use App\Models\PaymentLog;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UddoktaPayService
{
    public function __construct(private SettingsService $settings){}

    public function baseUrl(): string
    {
        $mode = $this->settings->get('payment_uddoktapay', 'mode', 'sandbox');
        $key = $mode === 'live' ? 'live_base_url' : 'sandbox_base_url';
        return rtrim((string)$this->settings->get('payment_uddoktapay', $key, 'https://sandbox.uddoktapay.com'), '/');
    }

    public function apiKey(): string
    {
        $mode = $this->settings->get('payment_uddoktapay', 'mode', 'sandbox');
        $key = $mode === 'live' ? 'live_api_key' : 'sandbox_api_key';
        return (string)$this->settings->get('payment_uddoktapay', $key, '');
    }

    public function createCharge(array $payload): array
    {
        $baseUrl = $this->baseUrl();
        $apiKey = $this->apiKey();
        if (!$apiKey) {
            throw ValidationException::withMessages(['payment' => 'UddoktaPay API key is not configured.']);
        }

        $url = $baseUrl . '/api/checkout-v2';

        $resp = Http::acceptJson()
            ->withHeaders(['RT-UDDOKTAPAY-API-KEY' => $apiKey])
            ->post($url, $payload);

        PaymentLog::create([
            'provider' => 'uddoktapay',
            'action' => 'create_charge',
            'request' => $payload,
            'response' => $resp->json(),
            'http_status' => $resp->status(),
        ]);

        if (!$resp->ok() || !($resp->json('status') ?? false)) {
            throw ValidationException::withMessages(['payment' => $resp->json('message') ?? 'Payment creation failed.']);
        }

        return $resp->json();
    }

    public function verifyPayment(string $invoiceId): array
    {
        $baseUrl = $this->baseUrl();
        $apiKey = $this->apiKey();
        $url = $baseUrl . '/api/verify-payment';

        $payload = ['invoice_id' => $invoiceId];

        $resp = Http::acceptJson()
            ->withHeaders(['RT-UDDOKTAPAY-API-KEY' => $apiKey])
            ->post($url, $payload);

        PaymentLog::create([
            'provider' => 'uddoktapay',
            'action' => 'verify_payment',
            'request' => $payload,
            'response' => $resp->json(),
            'http_status' => $resp->status(),
        ]);

        if (!$resp->ok()) {
            throw ValidationException::withMessages(['payment' => 'Payment verification failed.']);
        }

        return $resp->json();
    }
}
