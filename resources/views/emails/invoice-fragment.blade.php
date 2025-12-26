<div style="font-family: Arial, sans-serif; color: #111827;">
  <div style="display: flex; justify-content: space-between; align-items: flex-start;">
    <div style="max-width: 360px;">
      <h2 style="margin: 0 0 6px;">{{ $template['company_name'] ?? 'Company' }}</h2>
      <div style="color: #6b7280; font-size: 12px;">{{ $template['company_address'] ?? '' }}</div>
    </div>
    <div>
      <div><strong>Invoice</strong></div>
      <div style="color: #6b7280; font-size: 12px;">Order #{{ $order->order_number ?? $order->id }}</div>
      <div style="color: #6b7280; font-size: 12px;">Date: {{ $order->created_at?->format('Y-m-d') }}</div>
    </div>
  </div>

  <div style="margin-top: 16px;">
    <strong>Bill To</strong>
    <div style="color: #6b7280; font-size: 12px;">{{ $order->customer?->name ?? '-' }}</div>
    <div style="color: #6b7280; font-size: 12px;">{{ $order->customer?->email ?? '' }}</div>
  </div>

  <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
    <thead>
      <tr>
        <th style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px; background: #f9fafb;">
          Item
        </th>
        <th style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px; background: #f9fafb;">
          Qty
        </th>
        <th style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px; background: #f9fafb;">
          Price
        </th>
        <th style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px; background: #f9fafb;">
          Total
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($order->items as $item)
        <tr>
          <td style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px;">
            {{ $item->product_name ?? $item->product?->name ?? 'Item' }}
          </td>
          <td style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px;">
            {{ $item->qty ?? 1 }}
          </td>
          <td style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px;">
            {{ number_format((float) ($item->unit_price ?? 0), 2) }}
          </td>
          <td style="text-align: left; border-bottom: 1px solid #e5e7eb; padding: 8px 6px; font-size: 14px;">
            {{ number_format((float) ($item->line_total ?? 0), 2) }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
    <tbody>
      <tr>
        <td style="text-align: right; font-weight: 700; padding: 6px;">Subtotal</td>
        <td style="text-align: right; font-weight: 700; padding: 6px;">
          {{ number_format((float) ($order->subtotal ?? 0), 2) }}
        </td>
      </tr>
      <tr>
        <td style="text-align: right; font-weight: 700; padding: 6px;">Discount</td>
        <td style="text-align: right; font-weight: 700; padding: 6px;">
          -{{ number_format((float) ($order->discount_total ?? 0), 2) }}
        </td>
      </tr>
      <tr>
        <td style="text-align: right; font-weight: 700; padding: 6px;">Total</td>
        <td style="text-align: right; font-weight: 700; padding: 6px;">
          {{ number_format((float) ($order->total ?? 0), 2) }}
        </td>
      </tr>
    </tbody>
  </table>

  <div style="margin-top: 24px; font-size: 12px; color: #6b7280;">
    {{ $template['footer_note'] ?? '' }}
  </div>
</div>
