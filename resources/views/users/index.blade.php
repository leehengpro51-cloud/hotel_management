@extends('layouts.app')

@section('title', 'Staff User Management')

@section('content')
<!-- Header Banner -->
<div class="card card-hotel text-white mb-4 overflow-hidden border-0" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 70%, #152B44 100%);">
    <div class="p-4 p-md-5 text-center">
        <div class="hotel-logo-wrapper mb-3" style="padding: 2px;">
            <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel" class="hotel-logo-img" style="width: 58px; height: 58px;">
        </div>
        <h2 class="fw-bold mb-1 font-luxury">Staff & User Management</h2>
        <p class="text-light opacity-75 mb-0">Add, review, edit, and remove authorized administrator and staff accounts</p>
    </div>
</div>

<!-- Search & Top Actions -->
<div class="card card-hotel mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">
            <form action="{{ route('users.index') }}" method="GET" class="flex-grow-1" style="max-width: 480px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           value="{{ request('search') }}" 
                           placeholder="Search staff by name or email...">
                    <button type="submit" class="btn btn-navy">Search</button>
                    @if(request('search'))
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
                    @endif
                </div>
            </form>

            <a href="{{ route('users.create') }}" class="btn btn-gold px-3.5 py-2 rounded-pill d-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Add New User
            </a>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card card-hotel mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="fw-bold text-dark">
            Registered Users: <span class="badge bg-primary bg-opacity-10 text-primary fs-6">{{ $totalUsers }} Total</span>
        </div>
        <div class="text-muted small">
            Logged in as: <strong class="text-dark">{{ Auth::user()->name }}</strong>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hotel align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Staff Name</th>
                    <th>Email Address</th>
                    <th>Role & Status</th>
                    <th>Account Created</th>
                    <th class="text-end" style="min-width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-bold text-muted">#{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2.5">
                            <span class="badge rounded-circle bg-warning text-dark fw-bold" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.95rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            <div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                @if($user->id === Auth::id())
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.72rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Current Active Session
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-dark fw-semibold"><i class="bi bi-envelope text-muted me-1"></i> {{ $user->email }}</div>
                    </td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1">
                            <i class="bi bi-shield-check me-1"></i> Hotel Staff / Admin
                        </span>
                    </td>
                    <td>
                        <div class="small text-secondary">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
                        <div class="text-muted small" style="font-size: 0.75rem;">{{ $user->created_at ? $user->created_at->diffForHumans() : '' }}</div>
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit User">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            @if($user->id !== Auth::id())
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}" title="Delete User">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="You cannot delete your own active session">
                                    <i class="bi bi-lock-fill"></i>
                                </button>
                            @endif
                        </div>

                        @if($user->id !== Auth::id())
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h6 class="modal-title fw-bold">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm User Removal
                                        </h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start p-4">
                                        <p class="mb-2">Are you sure you want to remove staff user <strong>{{ $user->name }}</strong> (<code>{{ $user->email }}</code>)?</p>
                                        <p class="text-muted small mb-0">This account will immediately lose access to the Angkor Hotel Management System.</p>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Remove User
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        No staff users found matching your search.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white p-3 border-top d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
        </div>
        <div>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
