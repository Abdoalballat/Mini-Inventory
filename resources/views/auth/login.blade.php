<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NiceShop - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8f9fa; 
            color: #212529; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-logo { 
            font-weight: 700; 
            font-size: 1.75rem; 
            color: #111; 
            text-decoration: none; 
        }
        .card-custom { 
            background: #ffffff; 
            border-radius: 1.25rem; 
            border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.035); 
            width: 100%;
            max-width: 440px;
        }
        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e5e7eb;
            font-size: 0.9rem;
        }
        .form-control:focus {
            border-color: #18181b;
            box-shadow: 0 0 0 0.2rem rgba(24, 24, 27, 0.1);
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #4b5563;
            margin-left: 0.5rem;
            margin-bottom: 0.35rem;
        }
        .btn-dark-pill { 
            background: #18181b; 
            color: #fff; 
            border-radius: 50px; 
            padding: 0.75rem 1.6rem; 
            font-weight: 500; 
            font-size: 0.95rem; 
            border: none; 
            transition: background-color 0.2s ease;
        }
        .btn-dark-pill:hover { 
            background: #000; 
            color: #fff; 
        }
        .forgot-link {
            font-size: 0.85rem;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .forgot-link:hover {
            color: #111;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center py-5">
        <div class="card-custom p-4 p-md-5">
            
            <div class="text-center mb-4">
                <a href="#" class="brand-logo d-block mb-1">Nice<span class="text-secondary fw-normal">Shop</span></a>
                <p class="text-muted small">Sign in to manage your POS & Inventory</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 py-2 px-3 mb-4 small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success rounded-4 py-2 px-3 mb-4 small">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login.login') }}" method="POST">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="name@example.com" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="••••••••" 
                        required
                    >
                </div>

                <div class="form-check mb-4 ms-2">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">
                        Keep me signed in
                    </label>
                </div>

                <button type="submit" class="btn btn-dark-pill w-100 shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

        </div>
    </div>

</body>
</html>