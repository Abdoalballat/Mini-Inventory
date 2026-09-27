<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NiceShop - Set New Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #212529; }
        .main-header { background: #fff; padding: 18px 0; }
        .brand-logo { font-weight: 700; font-size: 1.55rem; color: #111; text-decoration: none; }
        .card-custom { background: #ffffff; border-radius: 1.25rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.035); }
        .btn-dark-pill { background: #18181b; color: #fff; border-radius: 50px; padding: 0.7rem 1.6rem; font-weight: 500; font-size: 0.95rem; border: none; width: 100%; }
        .btn-dark-pill:hover { background: #000; color: #fff; }
    </style>
</head>
<body>

    <header class="main-header border-bottom mb-5">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('login.page') }}" class="brand-logo">Nice<span class="text-secondary fw-normal">Shop</span></a>
        </div>
    </header>

    <main class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card-custom p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-lock text-dark fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Create New Password</h4>
                        <p class="text-muted small">Your OTP is verified. Enter your new password below to secure your account.</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger rounded-4 border-0 small mb-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('Succes'))
                        <div id="auto-dismiss-alert" class="alert alert-success rounded-4 border-0 small mb-3" style="width: fit-content; margin-left: 45%;">
                        {{ session('Succes') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('Failed'))
                        <div id="auto-dismiss-alert" class="alert alert-danger rounded-4 border-0 small mb-3" style="width: fit-content; margin-left: 45%;">
                        {{ session('Succes') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">New Password</label>
                            <input type="password" name="password" class="form-control rounded-pill px-3 py-2 @error('password') is-invalid @enderror" placeholder="Minimum 8 characters" required>
                            @error('password')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-pill px-3 py-2" placeholder="Repeat your new password" required>
                        </div>

                        <button type="submit" class="btn btn-dark-pill mb-3">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>
</html>