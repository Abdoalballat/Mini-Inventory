<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NiceShop - Invoices History</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html, body { overflow-x: hidden; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #212529; }
        .main-header { background: #fff; padding: 14px 0; }
        .brand-logo { font-weight: 700; font-size: 1.3rem; color: #111; text-decoration: none; }
        .dark-navbar { background-color: #191919; padding: 0.5rem 0; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .dark-navbar::-webkit-scrollbar { display: none; }
        .dark-navbar { -ms-overflow-style: none; scrollbar-width: none; }
        .dark-navbar .nav { flex-wrap: nowrap; }
        .dark-navbar .nav-link { color: #d1d5db !important; font-size: 0.82rem; font-weight: 500; padding: 0.5rem 0.9rem !important; }
        .dark-navbar .nav-link:hover, .dark-navbar .nav-link.active { color: #ffffff !important; }
        .card-custom { background: #ffffff; border-radius: 1.25rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.035); }
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.5rem 1.4rem; font-size: 0.85rem; text-decoration: none; white-space: nowrap; }
        .btn-dark-pill:hover { background: #000; color: #fff; }
        .btn-light-pill { background: #fff; color: #212529; border-radius: 50px; padding: 0.4rem 1rem; font-size: 0.85rem; border: 1px solid #e5e7eb; text-decoration: none; white-space: nowrap; }
        .btn-light-pill:hover { background: #f3f4f6; }
        .alert-floating-center { max-width: 92%; width: fit-content; margin: 0 auto 1rem; }

        /* ===== Mobile tightening ===== */
        @media (max-width: 576px) {
            .container { padding-left: 12px; padding-right: 12px; }
            .card-custom { border-radius: 1rem; padding: 1rem !important; }
            h4.fw-bold { font-size: 1.1rem; }
            .table { font-size: 0.8rem; }
            .btn-dark-pill { width: 100%; text-align: center; padding: 0.55rem 1rem; }
            .btn-light-pill { padding: 0.35rem 0.75rem; font-size: 0.78rem; }
        }
    </style>
</head>
<body>
    @if(session('Succes'))
    <div id="auto-dismiss-alert" class="alert alert-success rounded-4 border-0 small mb-3 alert-floating-center text-center">
    {{ session('Succes') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('Failed'))
    <div id="auto-dismiss-alert" class="alert alert-danger rounded-4 border-0 small mb-3 alert-floating-center text-center">
    {{ session('Succes') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

@if (session('error'))
<div class="alert alert-danger rounded-4 border-0 small mb-3 alert-floating-center text-center">
            {{ session('error') }}
    </div>
@endif
    <header class="main-header border-bottom">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('products.index') }}" class="brand-logo">Nice<span class="text-secondary fw-normal">Shop</span></a>
        </div>
    </header>

    <nav class="dark-navbar mb-4">
        <div class="container">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.create') }}">Add Product</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('invoice_items.create') }}">Create Invoice (POS)</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('invoices.index') }}">Invoices</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mb-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold m-0">Invoices History</h4>
                <p class="text-muted small m-0">View and track all completed POS transactions.</p>
            </div>
            <a href="{{ route('invoice_items.create') }}" class="btn btn-dark-pill">+ New POS Invoice</a>
        </div>

        <div class="card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted small border-bottom">
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <!-- <th>Items Count</th> -->
                            <th>Grand Total</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $invoice)
                            <tr>
                                <td class="fw-bold">#INV-{{ $invoice->id }}</td>
                                <td class="text-muted small">{{ $invoice->created_at->format('d M Y, h:i A') }}</td>
                                <!-- <td>{{ $invoice->items ? $invoice->items->count() : 0 }} items</td> -->
                                <td class="fw-bold text-dark">${{ number_format($invoice->total_price, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-light-pill btn-sm">
                                        <i class="bi bi-eye me-1"></i> View & Print
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No invoices generated yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
const alertElement = document.getElementById('auto-dismiss-alert');

if (alertElement) {
    setTimeout(() => {
      // Initialize or get the Bootstrap Alert instance
    const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
      // Triggers the fade out and removes the element from DOM
    bsAlert.close();
    }, 3000); // 3000ms = 3 seconds
}
});
</script>
</body>
</html>