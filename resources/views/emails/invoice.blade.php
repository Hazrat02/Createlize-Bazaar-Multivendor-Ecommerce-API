<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Invoice #{{ $order->order_number ?? $order->id }}</title>
    <style>
      body { font-family: Arial, sans-serif; color: #111827; margin: 24px; }
      .header { display: flex; justify-content: space-between; align-items: flex-start; }
      .company { max-width: 360px; }
      .muted { color: #6b7280; font-size: 12px; }
      table { width: 100%; border-collapse: collapse; margin-top: 16px; }
      th, td { text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px; }
      th { background: #f9fafb; font-weight: 600; }
      .total { text-align: right; font-weight: 700; }
      .footer { margin-top: 24px; font-size: 12px; color: #6b7280; }
    </style>
  </head>
  <body>
    @include('emails.invoice-fragment', ['order' => $order, 'template' => $template])
  </body>
</html>
