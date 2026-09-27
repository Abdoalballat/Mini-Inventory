<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NiceShop - Create POS Invoice</title>
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
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.6rem 1.6rem; font-weight: 500; font-size: 0.9rem; border: none; text-decoration: none; }
        .btn-dark-pill:hover { background: #000; color: #fff; }
        .btn-light-pill { background: #fff; color: #212529; border-radius: 50px; padding: 0.4rem 1.2rem; font-weight: 500; font-size: 0.85rem; border: 1px solid #e5e7eb; white-space: nowrap; }
        .btn-light-pill:hover { background: #f3f4f6; }
        .alert-floating-center { max-width: 92%; width: fit-content; margin: 0 auto 1rem; }

        /* ---- item row inputs: keep text from being clipped / overlapped by the number spinner ---- */
        .product-select { text-overflow: ellipsis; }
        .qty-input { text-align: center; }
        .price-input { text-align: right; }

        /* ===== Mobile tightening ===== */
        @media (max-width: 576px) {
            .container { padding-left: 12px; padding-right: 12px; }
            .card-custom { border-radius: 1rem; padding: 1rem !important; }
            h4.fw-bold { font-size: 1.05rem; }
            h5.fw-bold { font-size: 1rem; }
            .btn-light-pill { padding: 0.35rem 0.8rem; font-size: 0.78rem; }
            .fs-4 { font-size: 1.15rem !important; }
        }

        /* ===== Turn the items table into stacked cards below 768px ===== */
        @media (max-width: 768px) {
            #itemsTable thead { display: none; }
            #itemsTable, #itemsTable tbody { display: block; width: 100%; }
            #itemsTable tr.item-row {
                display: block;
                width: 100%;
                border: 1px solid #eef0f2;
                border-radius: 1rem;
                padding: 0.85rem 0.9rem;
                margin-bottom: 0.75rem;
                background: #fbfbfc;
            }
            #itemsTable td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 0.6rem;
                padding: 0.4rem 0;
                border: none;
                width: 100% !important;
            }
            #itemsTable td::before {
                content: attr(data-label);
                font-size: 0.72rem;
                font-weight: 600;
                color: #8a8f98;
                flex: 0 0 auto;
            }
            #itemsTable td .form-select,
            #itemsTable td .form-control {
                max-width: 62%;
                font-size: 0.82rem;
                padding: 0.4rem 0.8rem;
            }
            /* subtotal + remove button share one row, vertically centered, subtotal on the left of the X */
            #itemsTable td.totals-row {
                justify-content: space-between;
                align-items: center;
                padding-top: 0.6rem;
                margin-top: 0.2rem;
                border-top: 1px dashed #ecebee;
            }
            #itemsTable td.totals-row::before { content: none; }
            #itemsTable td.totals-row .row-subtotal {
                font-size: 0.95rem;
            }
            #itemsTable td.totals-row .remove-row {
                display: inline-flex;
                align-items: center;
            }
        }
    </style>
</head>
<body>

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
                <li class="nav-item"><a class="nav-link active " href="{{ route('invoice_items.create') }}">Create Invoice (POS)</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('invoices.index') }}">Invoices</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <main class="container mb-5">
        <form action="{{ route('invoice_items.store') }}" method="POST" id="posForm">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="card-custom p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                            <h4 class="fw-bold m-0"><i class="bi bi-receipt me-2"></i>Invoice Items</h4>
                            <button type="button" class="btn btn-light-pill" id="addRowBtn">
                                <i class="bi bi-plus-circle me-1"></i> Add Row
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle" id="itemsTable">
                                <thead class="text-muted small">
                                    <tr>
                                        <th style="width: 40%;">Product</th>
                                        <th style="width: 20%;">Qty</th>
                                        <th style="width: 20%;">Price ($)</th>
                                        <th style="width: 15%;">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td data-label="Product">
                                            <select name="items[0][product_id]" class="form-select rounded-pill product-select" required>
                                                <option value="" data-price="0">-- Select Product --</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                        {{ $product->product_name }} (Stock: {{ $product->count }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td data-label="Qty">
                                            <input type="number" name="items[0][quantity]" class="form-control rounded-pill qty-input" min="1" value="1" required>
                                        </td>
                                        <td data-label="Price ($)">
                                            <input type="number" step="0.01" class="form-control rounded-pill price-input" readonly value="0.00">
                                        </td>
                                        <td class="fw-bold text-dark row-subtotal totals-row d-none d-md-table-cell">$0.00</td>
                                        <td class="action-cell d-none d-md-table-cell">
                                            <button type="button" class="btn btn-link text-danger remove-row p-0"><i class="bi bi-x-circle fs-5"></i></button>
                                        </td>
                                        <!-- mobile-only combined row: subtotal + remove button side by side -->
                                        <td class="totals-row d-md-none">
                                            <span class="fw-bold text-dark row-subtotal-mobile">$0.00</span>
                                            <button type="button" class="btn btn-link text-danger remove-row p-0"><i class="bi bi-x-circle fs-5"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card-custom p-4">
                        <h5 class="fw-bold mb-3">Invoice Summary</h5>
                        <div class="d-flex justify-content-between text-muted mb-2">
                            <span>Total Items Qty:</span>
                            <span id="totalItemsCount" class="fw-semibold">0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fs-4 fw-bold text-dark mb-4">
                            <span>Grand Total:</span>
                            <span id="grandTotalDisplay">$0.00</span>
                        </div>

                        <button type="submit" class="btn btn-dark-pill w-100 py-3 fs-6 shadow-sm">
                            <i class="bi bi-check2-circle me-2"></i> Save & Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const products = @json($products);
        let rowIndex = 1;

        function calculateTotal() {
            let grandTotal = 0;
            let totalItems = 0;

            document.querySelectorAll('.item-row').forEach(row => {
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                const subtotal = price * qty;

                const text = '$' + subtotal.toFixed(2);
                row.querySelectorAll('.row-subtotal, .row-subtotal-mobile').forEach(el => el.innerText = text);
                grandTotal += subtotal;
                totalItems += qty;
            });

            document.getElementById('grandTotalDisplay').innerText = '$' + grandTotal.toFixed(2);
            document.getElementById('totalItemsCount').innerText = totalItems;
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const price = selectedOption.getAttribute('data-price') || 0;
                const row = e.target.closest('.item-row');
                row.querySelector('.price-input').value = parseFloat(price).toFixed(2);
                calculateTotal();
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input')) {
                calculateTotal();
            }
        });

        document.getElementById('addRowBtn').addEventListener('click', function() {
            const tbody = document.querySelector('#itemsTable tbody');
            let optionsHtml = '<option value="" data-price="0">-- Select Product --</option>';
            products.forEach(p => {
                optionsHtml += `<option value="${p.id}" data-price="${p.price}">${p.product_name} (Stock: ${p.count})</option>`;
            });

            const newRow = document.createElement('tr');
            newRow.classList.add('item-row');
            newRow.innerHTML = `
                <td data-label="Product">
                    <select name="items[${rowIndex}][product_id]" class="form-select rounded-pill product-select" required>
                        ${optionsHtml}
                    </select>
                </td>
                <td data-label="Qty">
                    <input type="number" name="items[${rowIndex}][quantity]" class="form-control rounded-pill qty-input" min="1" value="1" required>
                </td>
                <td data-label="Price ($)">
                    <input type="number" step="0.01" class="form-control rounded-pill price-input" readonly value="0.00">
                </td>
                <td class="fw-bold text-dark row-subtotal totals-row d-none d-md-table-cell">$0.00</td>
                <td class="action-cell d-none d-md-table-cell">
                    <button type="button" class="btn btn-link text-danger remove-row p-0"><i class="bi bi-x-circle fs-5"></i></button>
                </td>
                <td class="totals-row d-md-none">
                    <span class="fw-bold text-dark row-subtotal-mobile">$0.00</span>
                    <button type="button" class="btn btn-link text-danger remove-row p-0"><i class="bi bi-x-circle fs-5"></i></button>
                </td>
            `;
            tbody.appendChild(newRow);
            rowIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const row = e.target.closest('.item-row');
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    calculateTotal();
                }
            }
        });
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