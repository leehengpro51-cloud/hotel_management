@extends('layouts.app')

@section('title', 'Edit Room #' . $room->room_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Breadcrumb & Top Action -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-decoration-none">Rooms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Room #{{ $room->room_number }}</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Update Room Details</h3>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1.5">
                <i class="bi bi-arrow-left"></i> Back to Rooms
            </a>
        </div>

        <div class="card card-hotel shadow-sm overflow-hidden mb-5">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-2 border border-warning border-opacity-40">
                    <i class="bi bi-pencil-square fs-2 text-warning"></i>
                </div>
                <h4 class="fw-bold mb-1">Modify Room #{{ $room->room_number }}</h4>
                <p class="mb-0 text-light small opacity-75">Update room configurations, category assignment, or rate</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('rooms.update', $room->room_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: Room Identification & Bedding -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-info-circle-fill text-primary"></i>
                        <h6 class="fw-bold text-dark mb-0">Room Identification</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Room Number -->
                        <div class="col-md-4">
                            <label for="room_number" class="form-label fw-semibold small text-secondary">
                                Room Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="room_number" id="room_number" 
                                   class="form-control @error('room_number') is-invalid @enderror" 
                                   value="{{ old('room_number', $room->room_number) }}" required>
                            @error('room_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Floor -->
                        <div class="col-md-4">
                            <label for="floor" class="form-label fw-semibold small text-secondary">
                                Floor Level <span class="text-danger">*</span>
                            </label>
                            <select name="floor" id="floor" class="form-select @error('floor') is-invalid @enderror" required>
                                @foreach($floors as $fl)
                                    <option value="{{ $fl }}" {{ old('floor', $room->floor) == $fl ? 'selected' : '' }}>{{ $fl }}</option>
                                @endforeach
                            </select>
                            @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bed Type -->
                        <div class="col-md-4">
                            <label for="bed_type" class="form-label fw-semibold small text-secondary">
                                Bed Configuration <span class="text-danger">*</span>
                            </label>
                            <select name="bed_type" id="bed_type" class="form-select @error('bed_type') is-invalid @enderror" required>
                                @foreach($bedTypes as $bt)
                                    <option value="{{ $bt }}" {{ old('bed_type', $room->bed_type) == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                                @endforeach
                            </select>
                            @error('bed_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 2: Classification & Pricing -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-tag-fill text-warning"></i>
                        <h6 class="fw-bold text-dark mb-0">Classification & Pricing (Relational Link)</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Room Type -->
                        <div class="col-md-5">
                            <label for="type_id" class="form-label fw-semibold small text-secondary">
                                Assigned Category (Room Type) <span class="text-danger">*</span>
                            </label>
                            <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror" required>
                                @foreach($roomTypes as $type)
                                    <option value="{{ $type->type_id }}" {{ old('type_id', $room->type_id) == $type->type_id ? 'selected' : '' }}>
                                        {{ $type->type_name }} (Base: ${{ number_format($type->base_price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nightly Price -->
                        <div class="col-md-4">
                            <label for="price_per_night" class="form-label fw-semibold small text-secondary">
                                Price Per Night ($ USD) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" min="0" name="price_per_night" id="price_per_night" 
                                       class="form-control @error('price_per_night') is-invalid @enderror" 
                                       value="{{ old('price_per_night', $room->price_per_night) }}" required>
                            </div>
                            @error('price_per_night')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label for="status" class="form-label fw-semibold small text-secondary">
                                Room Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Available" {{ old('status', $room->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Occupied" {{ old('status', $room->status) == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="Reserved" {{ old('status', $room->status) == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                <option value="Maintenance" {{ old('status', $room->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 3: Additional Notes -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-card-text text-secondary"></i>
                        <h6 class="fw-bold text-dark mb-0">Additional Information & Amenities</h6>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold small text-secondary">Notes & Amenities</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-navy px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-check-lg text-warning"></i> Save Changes
                        </button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary px-4 py-2.5">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
