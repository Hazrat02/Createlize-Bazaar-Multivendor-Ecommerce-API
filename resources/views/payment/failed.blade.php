<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Payment Failed</title>
    <style>
      body { font-family: Arial, sans-serif; color: #111827; margin: 24px; }
      .card { max-width: 520px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; }
      .title { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
      .muted { color: #6b7280; font-size: 13px; }
    </style>
  </head>
  <body>
    <div class="card">
      <div class="title">Payment Failed</div>
      <div class="muted">{{ $message ?? 'Payment verification failed.' }}</div>
    </div>
  </body>
</html>
