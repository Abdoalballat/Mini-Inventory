<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NiceShop - Verify OTP</title>
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
        .otp-input { letter-spacing: 6px; font-size: 1.25rem; font-weight: 600; }
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
                            <i class="bi bi-shield-check text-dark fs-2"></i>
                        </div>
                        <h4 class="fw-bold">Enter OTP Code</h4>
                        <p class="text-muted small">Enter the 6-digit verification code sent to your email.</p>
                    </div>

                    @if(session('Succes'))
                        <div class="alert alert-success rounded-4 border-0 small mb-3">
                            {{ session('Succes') }}
                        </div>
                    @endif

                    @if(session('Failed') || session('error'))
                        <div class="alert alert-danger rounded-4 border-0 small mb-3">
                            {{ session('Failed') ?? session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('verify.otp') }}" method="POST">
                        @csrf
                        <input id="otp_input" type="hidden" name="email" value="{{ request('email') }}">

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Verification Code</label>
                            <input type="text" name="otp_code" maxlength="6" class="form-control rounded-pill px-3 py-2 text-center otp-input @error('otp_code') is-invalid @enderror" placeholder="••••••" required>
                            @error('otp_code')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button id="submit_btn" type="submit" class="btn btn-dark-pill mb-3">
                            Verify Code
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@if(session('retry_after'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let timeLeft = {{ session('retry_after') }};
        const submitBtn = document.getElementById('submit_btn');
        const otpInput = document.getElementById('otp_input');
        const originalBtnText = submitBtn.innerText;

        submitBtn.disabled = true;
        if (otpInput) {
            otpInput.disabled = true;
        }

        const timer = setInterval(function () {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            let formattedSeconds = seconds < 10 ? '0' + seconds : seconds;

            submitBtn.innerText = `Try again after ${minutes}:${formattedSeconds}`;
            timeLeft--;

            if (timeLeft < 0) {
                clearInterval(timer);
                submitBtn.disabled = false;
                if (otpInput) {
                    otpInput.disabled = false;
                }
                submitBtn.innerText = originalBtnText;
            }
        }, 1000);
    });
</script>
@endif
</body>
</html>