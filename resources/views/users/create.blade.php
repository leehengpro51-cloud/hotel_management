@extends('layouts.app')

@section('title', 'Add New Staff User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Staff Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add User</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Register Staff Account</h3>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>

        <div class="card card-hotel shadow-sm overflow-hidden mb-5">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="hotel-logo-wrapper mb-2" style="padding: 2px;">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel" class="hotel-logo-img" style="width: 54px; height: 54px;">
                </div>
                <h4 class="fw-bold mb-1">New Staff Account</h4>
                <p class="mb-0 text-light small opacity-75">Create administrative credentials for hotel reception or management</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small text-secondary">
                            Staff Full Name <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="name" 
                                   class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g. Sok Piseth, Sophea Chan" required autofocus>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small text-secondary">
                            Email Address (Login ID) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" 
                                   class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="staff@gmail.com" required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small text-secondary">
                            Account Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" id="password" 
                                   class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                   placeholder="Minimum 6 characters" required>
                            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted" type="button" id="toggleUserPasswordBtn" title="Show or hide password">
                                <i class="bi bi-eye" id="toggleUserPasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold small text-secondary">
                            Confirm Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-shield-check"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control border-start-0 border-end-0" 
                                   placeholder="Re-type password" required>
                            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted" type="button" id="toggleUserConfirmPasswordBtn" title="Show or hide password">
                                <i class="bi bi-eye" id="toggleUserConfirmPasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-navy px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-person-check-fill text-warning"></i> Add Staff Account
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4 py-2.5">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setupToggle(btnId, fieldId, iconId) {
        document.getElementById(btnId).addEventListener('click', function() {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }

    setupToggle('toggleUserPasswordBtn', 'password', 'toggleUserPasswordIcon');
    setupToggle('toggleUserConfirmPasswordBtn', 'password_confirmation', 'toggleUserConfirmPasswordIcon');
</script>
@endpush
