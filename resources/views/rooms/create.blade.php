@extends('layouts.app')

@section('title', 'Room Registration')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Breadcrumb & Top Action -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-decoration-none">Rooms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Room</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0 text-dark font-luxury">Register New Room</h3>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1.5">
                <i class="bi bi-arrow-left"></i> View Room List
            </a>
        </div>

        <!-- Registration Card (Matching Slide 6 Template) -->
        <div class="card card-hotel shadow-sm overflow-hidden mb-5">
            <!-- Header Banner -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%); border-bottom: 2px solid #D4AF37;">
                <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-20 mb-2 border border-warning border-opacity-40">
                    <i class="bi bi-door-open-fill fs-2 text-warning"></i>
                </div>
                <h4 class="fw-bold mb-1">Room Registration</h4>
                <p class="mb-0 text-light small opacity-75">Complete the form below to register a new room into the hotel database</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('rooms.store') }}" method="POST" id="roomForm">
                    @csrf

                    <!-- SECTION 1: Room Identification & Bedding -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-info-circle-fill text-primary"></i>
                        <h6 class="fw-bold text-dark mb-0">Room Identification</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Room Number -->
                        <div class="col-md-4">
                            <label for="room_number" class="form-label fw-semibold small text-secondary">
                                <i class="bi bi-hash"></i> Room Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="room_number" id="room_number" 
                                   class="form-control @error('room_number') is-invalid @enderror" 
                                   value="{{ old('room_number') }}" 
                                   placeholder="e.g. 101, 204, PH-01" required autofocus>
                            @error('room_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Floor -->
                        <div class="col-md-4">
                            <label for="floor" class="form-label fw-semibold small text-secondary">
                                <i class="bi bi-layers"></i> Floor Level <span class="text-danger">*</span>
                            </label>
                            <select name="floor" id="floor" class="form-select @error('floor') is-invalid @enderror" required>
                                <option value="">-- Select Floor --</option>
                                @foreach($floors as $fl)
                                    <option value="{{ $fl }}" {{ old('floor') == $fl ? 'selected' : '' }}>{{ $fl }}</option>
                                @endforeach
                            </select>
                            @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bed Type -->
                        <div class="col-md-4">
                            <label for="bed_type" class="form-label fw-semibold small text-secondary">
                                <i class="bi bi-moon-stars"></i> Bed Configuration <span class="text-danger">*</span>
                            </label>
                            <select name="bed_type" id="bed_type" class="form-select @error('bed_type') is-invalid @enderror" required>
                                <option value="">-- Select Bedding --</option>
                                @foreach($bedTypes as $bt)
                                    <option value="{{ $bt }}" {{ old('bed_type', '1 King Bed') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                                @endforeach
                            </select>
                            @error('bed_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 2: Classification & Pricing (Relational FK) -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-tag-fill text-warning"></i>
                        <h6 class="fw-bold text-dark mb-0">Classification & Pricing (Relational Link)</h6>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Room Type (Foreign Key) -->
                        <div class="col-md-5">
                            <label for="type_id" class="form-label fw-semibold small text-secondary">
                                <i class="bi bi-grid-fill"></i> Assigned Category (Room Type) <span class="text-danger">*</span>
                            </label>
                            <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror" required>
                                <option value="">-- Choose Category --</option>
                                @foreach($roomTypes as $type)
                                    <option value="{{ $type->type_id }}" data-price="{{ $type->base_price }}" {{ old('type_id') == $type->type_id ? 'selected' : '' }}>
                                        {{ $type->type_name }} (Base: ${{ number_format($type->base_price, 2) }} - Cap: {{ $type->capacity }})
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
                                <i class="bi bi-currency-dollar"></i> Price Per Night ($ USD) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" min="0" name="price_per_night" id="price_per_night" 
                                       class="form-control @error('price_per_night') is-invalid @enderror" 
                                       value="{{ old('price_per_night', '150.00') }}" required>
                            </div>
                            @error('price_per_night')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label for="status" class="form-label fw-semibold small text-secondary">
                                <i class="bi bi-activity"></i> Room Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Available" {{ old('status', 'Available') == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Occupied" {{ old('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="Reserved" {{ old('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SECTION 3: Additional Information -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-card-text text-secondary"></i>
                        <h6 class="fw-bold text-dark mb-0">Additional Information & Amenities</h6>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold small text-secondary">Enter any additional notes about the room, amenities, or view</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="e.g. Ocean view balcony, whirlpool tub, non-smoking, recently renovated...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit / Reset / View List Actions (Slide 6 Matching) -->
                    <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-navy px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-send-fill text-warning"></i> Submit Registration
                        </button>
                        <button type="reset" class="btn btn-outline-secondary px-3 py-2.5 d-flex align-items-center gap-2">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                        </button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-primary px-3 py-2.5 ms-auto d-flex align-items-center gap-2">
                            <i class="bi bi-list-task"></i> View Student/Room List
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
    // Automatically update price suggestion when category is changed
    document.getElementById('type_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const basePrice = selectedOption.getAttribute('data-price');
        if (basePrice) {
            document.getElementById('price_per_night').value = parseFloat(basePrice).toFixed(2);
        }
    });
</script>
@endpush
