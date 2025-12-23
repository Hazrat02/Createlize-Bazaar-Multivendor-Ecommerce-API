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
      .print-btn { margin-top: 16px; }
      @media print {
        .print-btn { display: none; }
      }
    </style>
  </head>
  <body>
    <div class="header">
      <div class="company">
        <h2>{{ $template['company_name'] ?? 'Company' }}</h2>
        <div class="muted">{{ $template['company_address'] ?? '' }}</div>
      </div>
      <div>
        <div><strong>Invoice</strong></div>
        <div class="muted">Order #{{ $order->order_number ?? $order->id }}</div>
        <div class="muted">Date: {{ $order->created_at?->format('Y-m-d') }}</div>
      </div>
    </div>

    <div style="margin-top: 16px;">
      <strong>Bill To</strong>
      <div class="muted">{{ $order->customer?->name ?? '-' }}</div>
      <div class="muted">{{ $order->customer?->email ?? '' }}</div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->items as $item)
          <tr>
            <td>{{ $item->product_name ?? $item->product?->name ?? 'Item' }}</td>
            <td>{{ $item->qty ?? 1 }}</td>
            <td>{{ number_format((float) ($item->unit_price ?? 0), 2) }}</td>
            <td>{{ number_format((float) ($item->line_total ?? 0), 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <table>
      <tbody>
        <tr>
          <td class="total">Subtotal</td>
          <td class="total">{{ number_format((float) ($order->subtotal ?? 0), 2) }}</td>
        </tr>
        <tr>
          <td class="total">Discount</td>
          <td class="total">-{{ number_format((float) ($order->discount_total ?? 0), 2) }}</td>
        </tr>
        <tr>
          <td class="total">Total</td>
          <td class="total">{{ number_format((float) ($order->total ?? 0), 2) }}</td>
        </tr>
      </tbody>
    </table>

    <button class="print-btn" onclick="window.print()">Print / Save PDF</button>

    <div class="footer">
      {{ $template['footer_note'] ?? '' }}
    </div>
  </body>
</html>
