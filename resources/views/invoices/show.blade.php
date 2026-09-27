<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NiceShop - Invoice #{{ $invoice->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #212529; }
        .card-custom { background: #ffffff; border-radius: 1.25rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.035); }
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.6rem 1.6rem; border: none; }
        .btn-dark-pill:hover { background: #000; color: #fff; }
        .btn-light-pill { background: #fff; color: #212529; border-radius: 50px; padding: 0.6rem 1.6rem; border: 1px solid #e5e7eb; text-decoration: none; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .card-custom { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('invoices.index') }}" class="btn btn-light-pill"><i class="bi bi-arrow-left me-1"></i> Back to Invoices</a>
            <button  onclick="window.print()" class="btn btn-dark-pill"><i class="bi bi-printer me-1"></i> Print Invoice</button>
        </div>

        <div class="card-custom p-4 p-md-5 mx-auto" style="max-width: 800px;">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Nice<span class="text-secondary fw-normal">Shop</span></h3>
                    <p class="text-muted small m-0">Point of Sale & Inventory</p>
                </div>
                <div class="text-end">
                    <h5 class="fw-bold m-0">INVOICE</h5>
                    <span class="text-muted small">#INV-{{ $invoice->id }}</span><br>
                    <span class="text-muted small">Date: {{ $invoice->created_at ? $invoice->created_at->format('d M Y') : '-' }}</span>
                </div>
            </div>

            <table class="table align-middle mb-4">
                <thead class="text-muted small border-bottom">
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->product_name ?? 'Item #'.$item->product_id }}</div>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->product_price, 2) }}</td>
                            <td class="text-end fw-bold">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between py-2 border-top">
                        <span class="fw-bold fs-5">Grand Total:</span>
                        <span class="fw-bold fs-5 text-dark">${{ number_format($invoice->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>