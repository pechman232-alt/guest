
@extends('layouts.app')

@section('title', __('wedding.edit') . ' · ' . $guest->full_name)
@section('page_heading', __('wedding.edit'))

@section('content')
<div class="guest-editor">

    <div class="guest-page-header">
        <div>
            <a href="{{ route('guests.index') }}" class="guest-back-link">
                <i class="bi bi-arrow-left"></i>
                {{ __('wedding.back_to_guests') }}
            </a>
            <h2 class="guest-page-title mt-3">{{ __('wedding.edit') }} {{ __('wedding.guest') }}</h2>
            <p class="guest-page-description">
                {{ __('wedding.guest_information_help') }}
            </p>
        </div>

        <div class="guest-profile-mark">
            <i class="bi bi-person-gear"></i>
        </div>
    </div>

    @if ($errors->any())
        <div class="guest-alert guest-alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>
                <strong>{{ __('wedding.validation_error_title') }}</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('guests.update', $guest) }}">
        @csrf
        @method('PUT')

        <section class="guest-form-card">
            <div class="guest-form-card-header">
                <div class="guest-section-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div>
                    <h5>{{ __('wedding.guest_information') }}</h5>
                    <p>{{ __('wedding.guest_information_help') }}</p>
                </div>
            </div>

            <div class="guest-form-body">
                <div class="row g-4">

                    <div class="col-12 col-md-6">
                        <label for="full_name" class="guest-field-label">
                            {{ __('wedding.guest_name') }}
                            <span class="guest-required">*</span>
                        </label>
                        <input
                            id="full_name"
                            name="full_name"
                            type="text"
                            class="form-control guest-field @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name', $guest->full_name) }}"
                            placeholder="{{ __('wedding.guest_name_placeholder') }}"
                            required
                            maxlength="255"
                            autocomplete="name"
                        >
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="phone" class="guest-field-label">
                            {{ __('wedding.phone') }}
                        </label>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            class="form-control guest-field @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $guest->phone) }}"
                            placeholder="{{ __('wedding.phone_placeholder') }}"
                            maxlength="30"
                            autocomplete="tel"
                        >
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="guest_side" class="guest-field-label">
                            {{ __('wedding.guest_side_question') }}
                            <span class="guest-required">*</span>
                        </label>
                        <select
                            id="guest_side"
                            name="guest_side"
                            class="form-select guest-field @error('guest_side') is-invalid @enderror"
                            required
                        >
                            <option value="bride" @selected(old('guest_side', $guest->guest_side) === 'bride')>
                                {{ __('wedding.bride') }}
                            </option>
                            <option value="groom" @selected(old('guest_side', $guest->guest_side) === 'groom')>
                                {{ __('wedding.groom') }}
                            </option>
                            <option value="both" @selected(old('guest_side', $guest->guest_side) === 'both')>
                                {{ __('wedding.both_sides') }}
                            </option>
                        </select>
                        @error('guest_side')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="guest_count" class="guest-field-label">
                            {{ __('wedding.people') }}
                            <span class="guest-required">*</span>
                        </label>
                        <input
                            id="guest_count"
                            name="guest_count"
                            type="number"
                            min="1"
                            max="50"
                            class="form-control guest-field @error('guest_count') is-invalid @enderror"
                            value="{{ old('guest_count', $guest->guest_count ?? 1) }}"
                            required
                        >
                        @error('guest_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="table_number" class="guest-field-label">
                            {{ __('wedding.table') }}
                        </label>
                        <input
                            id="table_number"
                            name="table_number"
                            type="text"
                            class="form-control guest-field @error('table_number') is-invalid @enderror"
                            value="{{ old('table_number', $guest->table_number) }}"
                            placeholder="{{ __('wedding.table_number_placeholder') }}"
                            maxlength="50"
                        >
                        @error('table_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="rsvp_status" class="guest-field-label">
                            {{ __('wedding.rsvp') }}
                        </label>
                        <select
                            id="rsvp_status"
                            name="rsvp_status"
                            class="form-select guest-field @error('rsvp_status') is-invalid @enderror"
                        >
                            <option value="pending" @selected(old('rsvp_status', $guest->rsvp_status) === 'pending')>
                                {{ __('wedding.pending') }}
                            </option>
                            <option value="confirmed" @selected(old('rsvp_status', $guest->rsvp_status) === 'confirmed')>
                                {{ __('wedding.confirmed') }}
                            </option>
                            <option value="declined" @selected(old('rsvp_status', $guest->rsvp_status) === 'declined')>
                                {{ __('wedding.declined') }}
                            </option>
                        </select>
                        @error('rsvp_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="notes" class="guest-field-label">
                            {{ __('wedding.notes') }}
                        </label>
                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            class="form-control guest-field @error('notes') is-invalid @enderror"
                            placeholder="{{ __('wedding.notes_placeholder') }}"
                        >{{ old('notes', $guest->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="guest-form-footer">
                <a href="{{ route('guests.show', $guest) }}" class="guest-btn guest-btn-light">
                    {{ __('wedding.cancel') }}
                </a>
                <button type="submit" class="guest-btn guest-btn-primary">
                    <i class="bi bi-check2-circle me-2"></i>
                    {{ __('wedding.save_guest') }}
                </button>
            </div>
        </section>
    </form>
</div>
@endsection
