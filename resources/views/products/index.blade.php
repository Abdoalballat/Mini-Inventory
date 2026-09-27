<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NiceShop - Inventory & POS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html, body { overflow-x: hidden; }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #212529; }
        .main-header { background: #fff; padding: 10px 0; }
        .brand-logo { font-weight: 700; font-size: 1.25rem; color: #111; text-decoration: none; }
        .search-bar-wrap { max-width: 480px; width: 100%; }
        .search-input { border-radius: 50px 0 0 50px; border: 1px solid #e5e7eb; padding: 0.55rem 1.1rem; font-size: 0.85rem; background-color: #fcfcfd; min-width: 0; }
        .search-btn { border-radius: 0 50px 50px 0; background-color: #1a1a1a; color: #fff; padding: 0 1rem; border: 1px solid #1a1a1a; flex-shrink: 0; }
        .header-icon-btn { position: relative; color: #333; font-size: 1.15rem; text-decoration: none; }
        .badge-count { position: absolute; top: -6px; right: -8px; background: #ff4757; color: #fff; font-size: 0.62rem; border-radius: 50%; padding: 2px 6px; }
        .dark-navbar { background-color: #191919; padding: 0.4rem 0; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .dark-navbar::-webkit-scrollbar { display: none; }
        .dark-navbar { -ms-overflow-style: none; scrollbar-width: none; }
        .dark-navbar .nav { flex-wrap: nowrap; }
        .dark-navbar .nav-link { color: #d1d5db !important; font-size: 0.8rem; font-weight: 500; padding: 0.5rem 0.75rem !important; }
        .dark-navbar .nav-link:hover, .dark-navbar .nav-link.active { color: #ffffff !important; }
        .card-custom { background: #ffffff; border-radius: 1.25rem; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.035); transition: 0.3s; }
        .card-custom:hover { transform: translateY(-4px); box-shadow: 0 14px 32px rgba(0,0,0,0.07); }
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.6rem 1.4rem; font-weight: 500; font-size: 0.88rem; border: none; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-dark-pill:hover { background: #000; color: #fff; }
        .btn-light-pill { background: #fff; color: #212529; border-radius: 50px; padding: 0.6rem 1.4rem; font-weight: 500; font-size: 0.88rem; border: 1px solid #e5e7eb; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-light-pill:hover { background: #f3f4f6; color: #000; }
        .alert-floating { max-width: 90%; margin: 15px auto; }

        @media (max-width: 576px) {
            .container { padding-left: 12px; padding-right: 12px; }
            .card-custom { border-radius: 1rem; }
            h1.fs-2 { font-size: 1.55rem !important; line-height: 1.25; }
            .lead.fs-6 { font-size: 0.85rem !important; }
            .btn-dark-pill, .btn-light-pill { width: 100%; padding: 0.65rem 1rem; font-size: 0.85rem; }
            .card-custom.p-4 { padding: 1.15rem !important; }
            .search-input { font-size: 0.8rem; padding: 0.5rem 0.9rem; }
            .header-icon-btn { font-size: 1rem; }
            .col-lg-5 [style*="height: 160px"] { height: 120px !important; }
            .bg-light.rounded-4.p-2 { height: 130px !important; }
        }
    </style>
</head>
<body>

    @if(session('Succes'))
    <div id="auto-dismiss-alert" class="alert alert-success alert-floating rounded-4 border-0 small text-center shadow-sm">
        {{ session('Succes') }}
        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('Failed'))
    <div id="auto-dismiss-alert" class="alert alert-danger alert-floating rounded-4 border-0 small text-center shadow-sm">
        {{ session('Failed') }}
        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <header class="main-header border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 gap-md-3">
                <a href="{{route('products.index')}}" class="brand-logo">Nice<span class="text-secondary fw-normal">Shop</span></a>

                <div class="d-flex align-items-center gap-2 gap-md-3 order-md-3">
                    <a href="{{route('invoices.index')}}" class="header-icon-btn" title="Open POS">
                        <i class="bi bi-cart"></i>
                        <span class="badge-count">POS</span>
                    </a>
                    <form method="POST" action="{{route('logout')}}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Log Out</button>
                    </form>
                </div>

                <div class="search-bar-wrap w-100 order-3 order-md-2 mx-auto">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex w-100">
                        <input
                            type="text"
                            name="search"
                            id="searchInput"
                            value="{{ request('search') }}"
                            class="form-control search-input"
                            placeholder="Search products..."
                            autocomplete="off"
                        >
                        <button class="search-btn d-flex align-items-center justify-content-center" type="submit" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <nav class="dark-navbar mb-4">
        <div class="container">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link active" href="{{ route('products.index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.create') }}">Add Product</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('invoice_items.create') }}">Create Invoice (POS)</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('invoices.index') }}">Invoices</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mb-5">
        <div class="card-custom p-4 p-md-5 mb-4 mb-md-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="fw-bold fs-2 fs-md-1 mb-2">Discover Amazing Products</h1>
                    <p class="text-muted mb-4 lead fs-6">
                        Explore our curated collection of premium inventory items designed to enhance your workflow.
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-2">
                        <a href="{{route('products.create')}}" class="btn btn-dark-pill shadow-sm">Add New Product</a>
                        <a href="{{ route('invoice_items.create') }}" class="btn btn-light-pill">Create Invoice (POS)</a>
                    </div>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-4 mt-4 text-muted small">
                        <div><i class="bi bi-truck me-1"></i> Fast Tracking</div>
                        <div><i class="bi bi-shield-check me-1"></i> Quality Guarantee</div>
                    </div>
                </div>

                @if ($best_seller)
                <div class="col-lg-5 text-center">
                    <div class="p-3 p-md-4 bg-white rounded-4 shadow-sm border border-light-subtle d-flex flex-column align-items-center mx-auto" style="max-width: 320px;">
                        <span class="badge bg-dark text-white rounded-pill px-3 py-2 mb-3">Best Seller</span>

                        <div class="my-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 160px;">
                            @php
                                $bestSellerUrl = filter_var($best_seller->image, FILTER_VALIDATE_URL) 
                                    ? $best_seller->image 
                                    : asset('storage/' . $best_seller->image);
                            @endphp
                            <img src="{{ $bestSellerUrl }}"
                                 alt="{{ $best_seller->product_name }}"
                                 class="img-fluid rounded-3"
                                 style="max-height: 100%; max-width: 100%; object-fit: contain;">
                        </div>

                        <h6 class="fw-bold mb-1 mt-2 text-dark">{{ $best_seller->product_name }}</h6>
                        <div class="fs-5 fw-bold text-danger">${{ number_format($best_seller->price, 2) }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
            <h4 class="fw-bold m-0 fs-5 fs-md-4">Inventory Catalog</h4>
            <span class="badge bg-light text-dark rounded-pill border px-3 py-2">Total: {{ $products->count() }}</span>
        </div>

        <div class="row g-3 g-md-4">
            @forelse($products as $product)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card-custom h-100 p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-dark text-white rounded-pill px-2 py-1 fw-normal" style="font-size: 0.72rem;">
                                    {{ $product->department }}
                                </span>
                                <span class="badge rounded-pill {{ $product->count > 5 ? 'bg-light text-dark border' : 'bg-danger text-white' }}" style="font-size: 0.72rem;">
                                    {{ $product->count }} in stock
                                </span>
                            </div>

                            <div class="bg-light rounded-4 p-2 text-center mb-3 d-flex align-items-center justify-content-center" style="height: 170px; overflow: hidden;">
                                @if(!empty($product->image))
                                    @php
                                        $productUrl = filter_var($product->image, FILTER_VALIDATE_URL) 
                                            ? $product->image 
                                            : asset('storage/' . $product->image);
                                    @endphp
                                    <img src="{{ $productUrl }}" alt="{{ $product->product_name }}" class="w-100 h-100 rounded-3" style="object-fit: cover;">
                                @else
                                    <i class="bi bi-box2 text-secondary" style="font-size: 2.5rem;"></i>
                                @endif
                            </div>

                            <h6 class="fw-bold mb-1 text-truncate" title="{{ $product->product_name }}">
                                {{ $product->product_name }}
                            </h6>
                            <p class="text-muted small mb-1">ID: #{{ $product->id }}</p>
                            <div class="fs-5 fw-bold text-dark mb-3">${{ number_format($product->price, 2) }}</div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-light-pill flex-grow-1 text-center">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are You Sure ?')" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-light-pill text-danger px-3" type="submit" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-warning text-center rounded-4 border-0 shadow-sm d-inline-block px-4 py-3">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        There are no products in the inventory yet.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alertElement = document.getElementById('auto-dismiss-alert');
            if (alertElement) {
                setTimeout(() => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
                    bsAlert.close();
                }, 3000);
            }
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            let query = this.value;
            fetch(`{{ route('products.index') }}?search=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                const parsed = new DOMParser().parseFromString(html, 'text/html');
                const newRow = parsed.querySelector('.row.g-3, .row.g-4');
                const currentRow = document.querySelector('.row.g-3, .row.g-4');
                if (newRow && currentRow) {
                    currentRow.innerHTML = newRow.innerHTML;
                }
            });
        });
    </script>
</body>
</html>