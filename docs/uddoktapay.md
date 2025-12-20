# UddoktaPay Integration (Createlize Bazaar)

This project uses the official UddoktaPay **Checkout v2** endpoint and the **Verify Payment** API.

Key references:
- Create Charge (`/api/checkout-v2`) citeturn0search0
- Verify Payment (`/api/verify-payment`) citeturn0search2

## Settings (DB-driven)

Admin Panel → **Payment Manage (UddoktaPay)** saves these keys in `settings` table (group: `payment_uddoktapay`):

- `mode`: `sandbox` | `live`
- `sandbox_base_url`: e.g. `https://sandbox.uddoktapay.com`
- `live_base_url`: your live base url
- `api_key`: Dashboard API key
- `redirect_url`: your app URL (used for success URL)
- `cancel_url`: your app cancel URL

No keys are hard-coded.

## Create Payment (Checkout)

Request to UddoktaPay:

Headers:
- `RT-UDDOKTAPAY-API-KEY: <api_key>`
- `Accept: application/json`
- `Content-Type: application/json` citeturn0search0

Payload:
- `full_name`, `email`, `amount`
- `metadata` (we send `{order_number, user_id}`)
- `redirect_url`, `cancel_url`
- `webhook_url` (optional)

Response:
- `payment_url` (customer should be redirected here) citeturn0search0

## Callback Verification

UddoktaPay returns an `invoice_id` after success (GET or POST depending on return_type). citeturn0search2

We verify payment by calling Verify Payment API with `invoice_id`:

POST `{base_url}/api/verify-payment` with header `RT-UDDOKTAPAY-API-KEY`. citeturn0search2

If status is `COMPLETED`, we mark order as paid and generate downloadable entitlements.

## Payment Logs

All requests/responses and verification attempts are stored in `payment_logs`.

