@extends('layouts.app')

@section('title', 'Edit Staff User - ' . $user->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Staff Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Edit Staff Account</h3>
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
                <h4 class="fw-bold mb-1">Modify Account: {{ $user->name }}</h4>
                <p class="mb-0 text-light small opacity-75">Update account name, email address, or reset staff password</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small text-secondary">
                            Staff Full Name <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="name" 
                                   class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold small text-secondary">
                            Email Address (Login ID) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" 
                                   class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Section (Optional) -->
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="fw-bold small text-dark mb-2">
                            <i class="bi bi-shield-lock me-1 text-primary"></i> Change Password (Leave blank to keep existing password)
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold small text-secondary">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" id="password" 
                                           class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                           placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0 bg-white text-muted" type="button" id="toggleEditPasswordBtn" title="Show or hide password">
                                        <i class="bi bi-eye" id="toggleEditPasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control border-start-0 border-end-0" 
                                           placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0 bg-white text-muted" type="button" id="toggleEditConfirmPasswordBtn" title="Show or hide password">
                                        <i class="bi bi-eye" id="toggleEditConfirmPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-navy px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-check-lg text-warning"></i> Save Changes
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

    setupToggle('toggleEditPasswordBtn', 'password', 'toggleEditPasswordIcon');
    setupToggle('toggleEditConfirmPasswordBtn', 'password_confirmation', 'toggleEditConfirmPasswordIcon');
</script>
@endpush
