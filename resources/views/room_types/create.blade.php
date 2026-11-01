@extends('layouts.app')

@section('title', 'Add New Room Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('room-types.index') }}" class="text-decoration-none">Room Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Category</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Create Room Category</h3>
            </div>
            <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>

        <div class="card card-hotel shadow-sm overflow-hidden mb-5">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-2 border border-warning border-opacity-40">
                    <i class="bi bi-grid-plus-fill fs-2 text-warning"></i>
                </div>
                <h4 class="fw-bold mb-1">New Category Definition</h4>
                <p class="mb-0 text-light small opacity-75">Define base rates, max guest occupancy, and wing locations</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('room-types.store') }}" method="POST">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="type_name" class="form-label fw-semibold small text-secondary">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="type_name" id="type_name" 
                               class="form-control @error('type_name') is-invalid @enderror" 
                               value="{{ old('type_name') }}" 
                               placeholder="e.g. Royal Honeymoon Suite, Deluxe Ocean Villa" required autofocus>
                        @error('type_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Base Nightly Price -->
                        <div class="col-md-6">
                            <label for="base_price" class="form-label fw-semibold small text-secondary">
                                Base Price Per Night ($) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" min="0" name="base_price" id="base_price" 
                                       class="form-control @error('base_price') is-invalid @enderror" 
                                       value="{{ old('base_price', '150.00') }}" required>
                            </div>
                            @error('base_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div class="col-md-6">
                            <label for="capacity" class="form-label fw-semibold small text-secondary">
                                Max Guest Capacity <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="1" max="20" name="capacity" id="capacity" 
                                   class="form-control @error('capacity') is-invalid @enderror" 
                                   value="{{ old('capacity', '2') }}" required>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Manager ID -->
                        <div class="col-md-6">
                            <label for="manager_id" class="form-label fw-semibold small text-secondary">
                                Manager In-Charge (manager_id)
                            </label>
                            <input type="text" name="manager_id" id="manager_id" 
                                   class="form-control @error('manager_id') is-invalid @enderror" 
                                   value="{{ old('manager_id') }}" 
                                   placeholder="e.g. MGR-101 (Michael Vance)">
                            @error('manager_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location ID -->
                        <div class="col-md-6">
                            <label for="location_id" class="form-label fw-semibold small text-secondary">
                                Hotel Location / Wing (location_id)
                            </label>
                            <input type="text" name="location_id" id="location_id" 
                                   class="form-control @error('location_id') is-invalid @enderror" 
                                   value="{{ old('location_id') }}" 
                                   placeholder="e.g. North Tower - Floors 3-5">
                            @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold small text-secondary">Category Description & Features</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Describe the typical layout, luxury perks, furnishings...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-navy px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-save-fill text-warning"></i> Save Room Category
                        </button>
                        <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary px-4 py-2.5">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
