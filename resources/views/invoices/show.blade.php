<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NiceShop - Invoice #{{ $invoice->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body { overflow-x: hidden; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #212529; }
        .card-custom { background: #ffffff; border-radius: 1.25rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.035); }
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.6rem 1.6rem; border: none; white-space: nowrap; }
        .btn-dark-pill:hover { background: #000; color: #fff; }
        .btn-light-pill { background: #fff; color: #212529; border-radius: 50px; padding: 0.6rem 1.6rem; border: 1px solid #e5e7eb; text-decoration: none; white-space: nowrap; }

        /* ===== Mobile tightening (screen only) ===== */
        @media screen and (max-width: 576px) {
            .container { padding-left: 12px; padding-right: 12px; }
            .page-wrap { margin-top: 1rem !important; margin-bottom: 1.5rem !important; }
            .card-custom { border-radius: 1rem; padding: 1.1rem !important; }
            .btn-dark-pill, .btn-light-pill { width: auto; text-align: center; padding: 0.4rem 1rem; font-size: 0.8rem; }
            .invoice-head h3 { font-size: 1.3rem; }
            .invoice-head h5 { font-size: 1rem; }
            .invoice-table { font-size: 0.8rem; }
            .invoice-table th, .invoice-table td { padding: 0.5rem 0.35rem; }
            .invoice-table td:first-child { word-break: break-word; }
        }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .card-custom { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <div class="container my-5 page-wrap">
        <div class="d-flex justify-content-start mb-4 no-print">
            <a href="{{ route('invoices.index') }}"  class="btn btn-light-pill"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card-custom p-4 p-md-5 mx-auto" style="max-width: 800px;">
            <div>
            <div class="invoice-head d-flex justify-content-between align-items-start gap-3 border-bottom pb-4 mb-4">
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

            <div class="table-responsive">
                <table class="table align-middle mb-4 invoice-table">
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
                                <td class="text-end text-nowrap">${{ number_format($item->product_price, 2) }}</td>
                                <td class="text-end fw-bold text-nowrap">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-12 col-md-5">
                    <div class="d-flex justify-content-between py-2 border-top">
                        <span class="fw-bold fs-5">Grand Total:</span>
                        <span class="fw-bold fs-5 text-dark">${{ number_format($invoice->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3 no-print" >
            <button onclick="window.print()" style="width: 35%;" class="btn btn-dark-pill btn-sm"><i class="bi bi-printer me-1"></i> Print</button>
        </div>
        </div>
    </div>
</body>

</html>