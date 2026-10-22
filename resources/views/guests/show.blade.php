
@extends('layouts.app')

@section('title', $guest->full_name . ' · ' . __('wedding.guest'))
@section('page_heading', __('wedding.guest'))

@section('content')
<div class="guest-editor">

    <div class="guest-page-header">
        <div>
            <a href="{{ route('guests.index') }}" class="guest-back-link">
                <i class="bi bi-arrow-left"></i>
                {{ __('wedding.back_to_guests') }}
            </a>

            <h2 class="guest-page-title mt-3">{{ __('wedding.guest') }}</h2>
            <p class="guest-page-description">{{ __('wedding.guest_information_help') }}</p>
        </div>

        <div class="guest-detail-actions">
            <a href="{{ route('guests.edit', $guest) }}" class="guest-btn guest-btn-primary">
                <i class="bi bi-pencil me-2"></i>
                {{ __('wedding.edit') }}
            </a>
        </div>
    </div>

    {{-- Guest Profile --}}
    <section class="guest-form-card mb-4">
        <div class="guest-profile-summary">
            <div class="guest-profile-avatar">
                {{ mb_strtoupper(mb_substr($guest->full_name, 0, 1)) }}
            </div>

            <div class="guest-profile-content">
                <h3>{{ $guest->full_name }}</h3>

                @if ($guest->phone)
                    <div class="guest-profile-phone">
                        <i class="bi bi-telephone me-1"></i>
                        {{ $guest->phone }}
                    </div>
                @endif

                <div class="guest-profile-badges">
                    <span class="guest-detail-badge">
                        {{ __('wedding.' . $guest->guest_side) }}
                    </span>

                    @if ($guest->checked_in_at)
                        <span class="guest-detail-badge guest-detail-success">
                            <i class="bi bi-check-circle me-1"></i>
                            {{ __('wedding.checked_in') }}
                        </span>
                    @else
                        <span class="guest-detail-badge guest-detail-neutral">
                            <i class="bi bi-clock me-1"></i>
                            {{ __('wedding.not_arrived') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Guest Information --}}
    <section class="guest-form-card mb-4">
        <div class="guest-form-card-header">
            <div class="guest-section-icon">
                <i class="bi bi-person-vcard"></i>
            </div>
            <div>
                <h5>{{ __('wedding.guest_information') }}</h5>
                <p>{{ __('wedding.guest_information_help') }}</p>
            </div>
        </div>

        <div class="guest-detail-grid">
            <div class="guest-detail-item">
                <span>{{ __('wedding.guest_name') }}</span>
                <strong>{{ $guest->full_name }}</strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.phone') }}</span>
                <strong>{{ $guest->phone ?: '—' }}</strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.side') }}</span>
                <strong>{{ __('wedding.' . $guest->guest_side) }}</strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.table') }}</span>
                <strong>{{ $guest->table_number ?: '—' }}</strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.people') }}</span>
                <strong>{{ number_format((int) $guest->guest_count) }}</strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.rsvp') }}</span>
                @php
                    $rsvpClass = match ($guest->rsvp_status) {
                        'confirmed' => 'guest-detail-success',
                        'declined' => 'guest-detail-danger',
                        default => 'guest-detail-pending',
                    };
                @endphp
                <strong>
                    <span class="guest-detail-badge {{ $rsvpClass }}">
                        {{ __('wedding.' . $guest->rsvp_status) }}
                    </span>
                </strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.status') }}</span>
                <strong>
                    {{ $guest->checked_in_at ? __('wedding.checked_in') : __('wedding.not_arrived') }}
                </strong>
            </div>

            <div class="guest-detail-item">
                <span>{{ __('wedding.created_at') }}</span>
                <strong>{{ $guest->created_at?->format('d M Y, H:i') ?? '—' }}</strong>
            </div>
        </div>

        @if ($guest->notes)
            <div class="guest-notes">
                <div class="guest-notes-title">
                    <i class="bi bi-sticky me-2"></i>
                    {{ __('wedding.notes') }}
                </div>
                <p class="mb-0">{{ $guest->notes }}</p>
            </div>
        @endif
    </section>

    {{-- Check-in Actions --}}
    <section class="guest-form-card">
        <div class="guest-form-card-header">
            <div class="guest-section-icon">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <div>
                <h5>{{ __('wedding.status') }}</h5>
                <p>{{ __('wedding.checked_in') }} / {{ __('wedding.not_arrived') }}</p>
            </div>
        </div>

        <div class="guest-detail-footer">
            @if (!$guest->checked_in_at)
                <form
                    method="POST"
                    action="{{ route('guests.checkin', $guest) }}"
                    onsubmit="return confirm(@js(__('wedding.check_in') . '?'))"
                >
                    @csrf
                    <button type="submit" class="guest-btn guest-btn-success">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ __('wedding.check_in') }}
                    </button>
                </form>
            @else
                <div class="guest-checkin-time">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ __('wedding.checked_in') }}
                    @if ($guest->checked_in_at)
                        · {{ $guest->checked_in_at->format('d M Y, H:i') }}
                    @endif
                </div>

                <form
                    method="POST"
                    action="{{ route('guests.checkin.undo', $guest) }}"
                    onsubmit="return confirm(@js(__('wedding.confirm_undo')))"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="guest-btn guest-btn-light">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        {{ __('wedding.undo_checkin') }}
                    </button>
                </form>
            @endif
        </div>
    </section>

</div>
@endsection
