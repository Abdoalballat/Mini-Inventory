<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>NiceShop - Edit Product</title>
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
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.7rem 1.6rem; font-weight: 500; font-size: 0.95rem; border: none; width: 100%; }
        .btn-dark-pill:hover { background: #000; }

        @media (max-width: 576px) {
            .container { padding-left: 12px; padding-right: 12px; }
            .card-custom { border-radius: 1rem; }
            .card-custom.p-4 { padding: 1.15rem !important; }
            h3.fw-bold { font-size: 1.2rem; }
            .form-label.small { font-size: 0.8rem; }
            .form-control { font-size: 0.85rem; padding-top: 0.55rem; padding-bottom: 0.55rem; }
            .btn-dark-pill { font-size: 0.88rem; padding: 0.65rem 1rem; }
            [style*="height: 140px"] { height: 110px !important; }
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
                <li class="nav-item"><a class="nav-link" href="{{ route('products.create') }}">+ Add Product</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('invoice_items.create') }}">Create Invoice (POS)</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('invoices.index') }}">Invoices</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card-custom p-4 p-md-5">
                    <div class="mb-4">
                        <a href="{{ route('products.index') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Back to Catalog</a>
                        <h3 class="fw-bold mt-2">Edit Product #{{ $product->id }}</h3>
                        <p class="text-muted small">Update product pricing, stock count, and details.</p>
                    </div>

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Product Name</label>
                            <input type="text" name="product_name" class="form-control rounded-pill px-3 py-2 @error('product_name') is-invalid @enderror" value="{{ old('product_name', $product->product_name) }}" required>
                            @error('product_name') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Department / Category</label>
                            <input type="text" name="department" class="form-control rounded-pill px-3 py-2 @error('department') is-invalid @enderror" value="{{ old('department', $product->department) }}" required>
                            @error('department') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Description </label>
                            <input type="text" name="description" class="form-control rounded-pill px-3 py-2 @error('description') is-invalid @enderror" value="{{ old('description', $product->description) }}" required>
                            @error('description') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Current Product Image</label>
                            <div class="mb-2 p-2 bg-light rounded-4 text-center d-flex align-items-center justify-content-center" style="height: 140px;">
                                @if(!empty($product->image))
                                    @php
                                        $productUrl = filter_var($product->image, FILTER_VALIDATE_URL)
                                            ? $product->image
                                            : asset('storage/' . $product->image);
                                    @endphp
                                    <img src="{{ $productUrl }}" alt="{{ $product->product_name }}" class="img-fluid rounded-3" style="max-height: 100%; object-fit: contain;">
                                @else
                                    <div class="text-muted small">
                                        <i class="bi bi-image d-block fs-3 mb-1"></i>
                                        No image uploaded yet
                                    </div>
                                @endif
                            </div>
                            <label class="form-label fw-semibold small">Change Image</label>
                            <input type="file" name="image" class="form-control rounded-pill px-3 py-2 @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold small">Stock Quantity</label>
                                <input type="number" name="count" min="0" class="form-control rounded-pill px-3 py-2 @error('count') is-invalid @enderror" value="{{ old('count', $product->count) }}" required>
                                @error('count') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold small">Unit Price ($)</label>
                                <input type="number" step="0.01" min="0" name="price" class="form-control rounded-pill px-3 py-2 @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                                @error('price') <div class="invalid-feedback ms-2">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark-pill">
                            <i class="bi bi-arrow-repeat me-1"></i> Update Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>
</html>