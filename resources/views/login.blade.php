@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="card card-hotel shadow-lg border-0 overflow-hidden">
            <!-- Header Banner -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="hotel-logo-wrapper mb-3" style="padding: 3px; box-shadow: 0 0 16px rgba(212, 175, 55, 0.5);">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel Logo" class="hotel-logo-img" style="width: 74px; height: 74px;">
                </div>
                <h3 class="fw-bold mb-1 font-luxury">Login Form</h3>
                <p class="mb-0 text-light small opacity-75">Sign in to Angkor Hotel Management System</p>
            </div>

            <!-- Form Body -->
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary small">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" 
                                   class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email', 'Lyheng@gmail.com') }}" 
                                   placeholder="Lyheng@gmail.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" id="password" 
                                   class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                   value="lyheng123" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted" type="button" id="togglePasswordBtn" title="Show or hide password">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" checked>
                            <label for="remember" class="form-check-label small text-muted">Remember session</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-gold py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </div>


                    <div class="text-center small text-muted">
                        Don't have a staff account? 
                        <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePasswordBtn').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
@endpush
