@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="card card-hotel shadow-lg border-0 overflow-hidden">
            <!-- Header Banner -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="hotel-logo-wrapper mb-3" style="padding: 3px; box-shadow: 0 0 16px rgba(212, 175, 55, 0.5);">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel Logo" class="hotel-logo-img" style="width: 74px; height: 74px;">
                </div>
                <h3 class="fw-bold mb-1 font-luxury">Register Form</h3>
                <p class="mb-0 text-light small opacity-75">Create staff account for Angkor Hotel Management</p>
            </div>

            <!-- Form Body -->
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-secondary small">Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="name" 
                                   class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="please input your name" required autofocus>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary small">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" 
                                   class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="adminwoman@gmail.com" required>
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
                                   class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                   placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-check"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control border-start-0" 
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-gold py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-person-check-fill"></i> Register
                        </button>
                    </div>

                    <div class="text-center small text-muted">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
