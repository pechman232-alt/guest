
@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                {{ __('wedding.create_guest_title') }}
            </h4>
            <p class="text-muted mb-0 small">
                {{ __('wedding.create_guest_subtitle') }}
            </p>
        </div>

        <a href="{{ route('guests.index') }}"
           class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>
            {{ __('wedding.back_to_guests') }}
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10 col-xxl-9">
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-3 p-md-4 p-lg-5">
                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">
                            {{ __('wedding.guest_information') }}
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ __('wedding.guest_information_help') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('guests.store') }}">
                        @csrf

                        <input type="hidden" name="rsvp_status" value="pending">

                        <div class="row g-3 g-lg-4">

                            {{-- Guest Name --}}
                            <div class="col-12 col-md-6">
                                <label for="full_name" class="form-label fw-semibold">
                                    {{ __('wedding.guest_name') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="full_name"
                                    name="full_name"
                                    class="form-control @error('full_name') is-invalid @enderror"
                                    value="{{ old('full_name') }}"
                                    placeholder="{{ __('wedding.guest_name_placeholder') }}"
                                    maxlength="150"
                                    required
                                    autofocus
                                >

                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    {{ __('wedding.phone') }}
                                    <span class="text-muted small">
                                        ({{ __('wedding.optional') }})
                                    </span>
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="{{ __('wedding.phone_placeholder') }}"
                                    maxlength="40"
                                >

                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Guest Side --}}
                            <div class="col-12 col-md-6">
                                <label for="guest_side" class="form-label fw-semibold">
                                    {{ __('wedding.guest_side_question') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="guest_side"
                                    name="guest_side"
                                    class="form-select @error('guest_side') is-invalid @enderror"
                                    required
                                >
                                    <option value="groom"
                                        {{ old('guest_side', 'groom') === 'groom' ? 'selected' : '' }}>
                                        {{ __('wedding.groom_side') }}
                                    </option>

                                    <option value="bride"
                                        {{ old('guest_side') === 'bride' ? 'selected' : '' }}>
                                        {{ __('wedding.bride_side') }}
                                    </option>

                                    <option value="both"
                                        {{ old('guest_side') === 'both' ? 'selected' : '' }}>
                                        {{ __('wedding.both_sides') }}
                                    </option>
                                </select>

                                @error('guest_side')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Guest Count --}}
                            <div class="col-12 col-md-6">
                                <label for="guest_count" class="form-label fw-semibold">
                                    {{ __('wedding.guest_count') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    id="guest_count"
                                    name="guest_count"
                                    class="form-control @error('guest_count') is-invalid @enderror"
                                    value="{{ old('guest_count', 1) }}"
                                    min="1"
                                    max="50"
                                    required
                                >

                                @error('guest_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Table Number --}}
                            <div class="col-12 col-md-6">
                                <label for="table_number" class="form-label fw-semibold">
                                    {{ __('wedding.table_number') }}
                                    <span class="text-muted small">
                                        ({{ __('wedding.optional') }})
                                    </span>
                                </label>

                                <input
                                    type="text"
                                    id="table_number"
                                    name="table_number"
                                    class="form-control @error('table_number') is-invalid @enderror"
                                    value="{{ old('table_number') }}"
                                    placeholder="{{ __('wedding.table_number_placeholder') }}"
                                    maxlength="30"
                                >

                                @error('table_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('guests.index') }}"
                               class="btn btn-outline-secondary px-4">
                                {{ __('wedding.cancel') }}
                            </a>

                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                {{ __('wedding.save_guest') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
