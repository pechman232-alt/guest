
@extends('layouts.app')

@section('title', __('wedding.guests'))
@section('page_heading', __('wedding.guests'))

@section('content')
<div class="guest-page">

    {{-- Header --}}
    <div class="guest-header mb-4">
        <div>
            <div class="guest-eyebrow">
                <i class="bi bi-heart-fill me-1"></i>
                WEDDING MANAGEMENT
            </div>
            <h3 class="guest-title">{{ __('wedding.guest_list') }}</h3>
            <p class="guest-subtitle mb-0">
                {{ __('wedding.guest_list_desc') }}
            </p>
        </div>

        <a href="{{ route('guests.create') }}" class="btn guest-add-btn">
            <i class="bi bi-plus-lg me-2"></i>
            {{ __('wedding.add_guest') }}
        </a>
    </div>

    {{-- Search & Filters --}}
    <div class="guest-panel mb-4">
        <div class="guest-panel-heading">
            <div class="d-flex align-items-center gap-2">
                <span class="guest-heading-icon">
                    <i class="bi bi-funnel"></i>
                </span>
                <div>
                    <h5 class="mb-0 fw-bold">{{ __('wedding.search') }}</h5>
                    <small class="text-secondary">
                        {{ __('wedding.guest_list_desc') }}
                    </small>
                </div>
            </div>
        </div>

        <div class="p-3 p-lg-4">
            <form method="GET" action="{{ route('guests.index') }}">
                <div class="row g-3 align-items-end">

                    <div class="col-12 col-lg-5">
                        <label for="search" class="guest-label">
                            {{ __('wedding.name') }}
                        </label>
                        <div class="guest-input-wrap">
                            <i class="bi bi-search"></i>
                            <input
                                id="search"
                                type="search"
                                name="search"
                                class="form-control guest-input"
                                value="{{ request('search') }}"
                                placeholder="{{ __('wedding.search_placeholder') }}"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <label for="side" class="guest-label">
                            {{ __('wedding.side') }}
                        </label>
                        <select id="side" name="side" class="form-select guest-input">
                            <option value="">{{ __('wedding.all_sides') }}</option>
                            @foreach (['bride', 'groom', 'both'] as $side)
                                <option
                                    value="{{ $side }}"
                                    @selected(request('side') === $side)
                                >
                                    {{ __('wedding.' . $side) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-2">
                        <label for="status" class="guest-label">
                            {{ __('wedding.status') }}
                        </label>
                        <select id="status" name="status" class="form-select guest-input">
                            <option value="">{{ __('wedding.all_statuses') }}</option>
                            <option value="checked_in"
                                @selected(request('status') === 'checked_in')>
                                {{ __('wedding.checked_in') }}
                            </option>
                            <option value="not_arrived"
                                @selected(request('status') === 'not_arrived')>
                                {{ __('wedding.not_arrived') }}
                            </option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn guest-search-btn flex-grow-1">
                            <i class="bi bi-search me-1"></i>
                            {{ __('wedding.search') }}
                        </button>

                        @if (request()->hasAny(['search', 'side', 'status']))
                            <a
                                href="{{ route('guests.index') }}"
                                class="btn guest-clear-btn"
                                title="{{ __('wedding.clear_filters') }}"
                                aria-label="{{ __('wedding.clear_filters') }}"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Guest List --}}
    <div class="guest-panel">

        <div class="guest-list-toolbar">
            <div>
                <h5 class="fw-bold mb-1">{{ __('wedding.guest_list') }}</h5>
                <span class="text-secondary small">
                    {{ __('wedding.total') }}:
                    <strong class="guest-total">{{ number_format($guests->total()) }}</strong>
                </span>
            </div>

            <div class="guest-toolbar-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table guest-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>{{ __('wedding.name') }}</th>
                        <th>{{ __('wedding.side') }}</th>
                        <th>{{ __('wedding.table') }}</th>
                        <th>{{ __('wedding.people') }}</th>
                        <th>{{ __('wedding.rsvp') }}</th>
                        <th>{{ __('wedding.status') }}</th>
                        <th class="text-end">{{ __('wedding.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($guests as $guest)
                        <tr>
                            {{-- Guest identity --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="guest-avatar">
                                        {{ mb_strtoupper(mb_substr($guest->full_name, 0, 1)) }}
                                    </div>

                                    <div class="guest-identity">
                                        <div class="guest-name">{{ $guest->full_name }}</div>
                                        @if ($guest->phone)
                                            <div class="guest-phone">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $guest->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Guest side --}}
                            <td>
                                <span class="guest-side-badge">
                                    {{ __('wedding.' . $guest->guest_side) }}
                                </span>
                            </td>

                            {{-- Table --}}
                            <td>
                                @if ($guest->table_number)
                                    <span class="guest-table-number">
                                        <i class="bi bi-grid-3x3-gap me-1"></i>
                                        {{ $guest->table_number }}
                                    </span>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Guest count --}}
                            <td>
                                <span class="guest-count">
                                    {{ number_format((int) $guest->guest_count) }}
                                </span>
                            </td>

                            {{-- RSVP --}}
                            <td>
                                @php
                                    $rsvpClass = match ($guest->rsvp_status) {
                                        'confirmed' => 'guest-badge-confirmed',
                                        'declined' => 'guest-badge-declined',
                                        default => 'guest-badge-pending',
                                    };
                                @endphp

                                <span class="guest-badge {{ $rsvpClass }}">
                                    <span class="guest-badge-dot"></span>
                                    {{ __('wedding.' . $guest->rsvp_status) }}
                                </span>
                            </td>

                            {{-- Check-in status --}}
                            <td>
                                @if ($guest->checked_in_at)
                                    <span class="guest-badge guest-badge-confirmed">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ __('wedding.checked_in') }}
                                    </span>
                                @else
                                    <span class="guest-badge guest-badge-neutral">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ __('wedding.not_arrived') }}
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="guest-actions justify-content-end">

                                    <a
                                        href="{{ route('guests.show', $guest) }}"
                                        class="guest-action guest-action-view"
                                        title="{{ __('wedding.view') }}"
                                        aria-label="{{ __('wedding.view') }}"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('guests.edit', $guest) }}"
                                        class="guest-action guest-action-edit"
                                        title="{{ __('wedding.edit') }}"
                                        aria-label="{{ __('wedding.edit') }}"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if (!$guest->checked_in_at)
                                        <form
                                            method="POST"
                                            action="{{ route('guests.checkin', $guest) }}"
                                            onsubmit="return confirm(@js(__('wedding.check_in') . '?'))"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="guest-action guest-action-checkin"
                                                title="{{ __('wedding.check_in') }}"
                                                aria-label="{{ __('wedding.check_in') }}"
                                            >
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form
                                            method="POST"
                                            action="{{ route('guests.checkin.undo', $guest) }}"
                                            onsubmit="return confirm(@js(__('wedding.confirm_undo')))"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="guest-action guest-action-undo"
                                                title="{{ __('wedding.undo_checkin') }}"
                                                aria-label="{{ __('wedding.undo_checkin') }}"
                                            >
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form
                                        method="POST"
                                        action="{{ route('guests.destroy', $guest) }}"
                                        onsubmit="return confirm(@js(__('wedding.confirm_delete')))"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="guest-action guest-action-delete"
                                            title="{{ __('wedding.delete') }}"
                                            aria-label="{{ __('wedding.delete') }}"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="guest-empty-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6 class="fw-bold mt-3">{{ __('wedding.no_guests') }}</h6>
                                <p class="text-secondary small mb-3">
                                    {{ __('wedding.guest_list_desc') }}
                                </p>
                                <a href="{{ route('guests.create') }}" class="btn guest-add-btn">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    {{ __('wedding.add_guest') }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($guests->hasPages())
            <div class="guest-pagination">
                {{ $guests->withQueryString()->links() }}
            </div>
        @endif

    </div>
</div>

<style>
    .guest-page {
        --guest-primary: #b7192f;
        --guest-primary-hover: #971429;
        --guest-border: #e9ebef;
        --guest-muted: #737985;
        color: #242833;
    }

    .guest-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .guest-eyebrow {
        color: var(--guest-primary);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
    }

    .guest-title {
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
        letter-spacing: -0.7px;
        margin-bottom: 6px;
    }

    .guest-subtitle {
        color: var(--guest-muted);
        font-size: 14px;
    }

    .guest-add-btn {
        background: var(--guest-primary);
        color: #fff;
        border: 1px solid var(--guest-primary);
        border-radius: 10px;
        padding: 11px 17px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(183, 25, 47, .12);
        transition: .2s ease;
    }

    .guest-add-btn:hover {
        color: #fff;
        background: var(--guest-primary-hover);
        border-color: var(--guest-primary-hover);
        transform: translateY(-1px);
    }

    .guest-panel {
        background: #fff;
        border: 1px solid var(--guest-border);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 3px 14px rgba(25, 32, 48, .035);
    }

    .guest-panel-heading {
        padding: 18px 22px;
        border-bottom: 1px solid #f0f1f4;
    }

    .guest-heading-icon,
    .guest-toolbar-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 11px;
        background: #fff0f2;
        color: var(--guest-primary);
        font-size: 18px;
    }

    .guest-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #555b67;
        margin-bottom: 7px;
    }

    .guest-input-wrap {
        position: relative;
    }

    .guest-input-wrap > i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #8b919c;
        pointer-events: none;
    }

    .guest-input {
        min-height: 43px;
        border: 1px solid #e1e4e9;
        border-radius: 9px;
        font-size: 13px;
        background-color: #fff;
    }

    .guest-input-wrap .guest-input {
        padding-left: 38px;
    }

    .guest-input:focus {
        border-color: #d88794;
        box-shadow: 0 0 0 3px rgba(183, 25, 47, .08);
    }

    .guest-search-btn {
        min-height: 43px;
        border: 1px solid #252934;
        border-radius: 9px;
        background: #252934;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .guest-search-btn:hover {
        color: #fff;
        background: #11141a;
    }

    .guest-clear-btn {
        min-height: 43px;
        min-width: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        border-color: #e1e4e9;
    }

    .guest-list-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 22px;
        border-bottom: 1px solid #f0f1f4;
    }

    .guest-total {
        color: var(--guest-primary);
    }

    .guest-table {
        font-size: 13px;
        white-space: nowrap;
    }

    .guest-table thead th {
        padding: 14px 18px;
        background: #f8f9fb;
        border-bottom: 1px solid var(--guest-border);
        color: #666c78;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .45px;
    }

    .guest-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #f0f1f4;
    }

    .guest-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .guest-table tbody tr {
        transition: background .15s ease;
    }

    .guest-table tbody tr:hover {
        background: #fdfbfc;
    }

    .guest-avatar {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fff0f2;
        color: var(--guest-primary);
        font-size: 15px;
        font-weight: 800;
    }

    .guest-name {
        color: #252934;
        font-size: 13px;
        font-weight: 750;
        white-space: normal;
    }

    .guest-phone {
        color: var(--guest-muted);
        font-size: 11px;
        margin-top: 4px;
    }

    .guest-side-badge,
    .guest-table-number,
    .guest-count {
        font-size: 12px;
        font-weight: 700;
    }

    .guest-side-badge {
        display: inline-block;
        padding: 6px 9px;
        border: 1px solid #e8eaf0;
        background: #f8f9fb;
        border-radius: 7px;
    }

    .guest-table-number {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 7px;
        background: #f2f5fa;
        color: #505c70;
    }

    .guest-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 7px;
        background: #f4f5f7;
        border-radius: 8px;
    }

    .guest-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 7px;
        padding: 6px 9px;
        font-size: 11px;
        font-weight: 750;
    }

    .guest-badge-dot {
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
    }

    .guest-badge-confirmed {
        color: #18794e;
        background: #eaf8f0;
    }

    .guest-badge-pending {
        color: #936200;
        background: #fff6dc;
    }

    .guest-badge-declined {
        color: #b42332;
        background: #fff0f0;
    }

    .guest-badge-neutral {
        color: #646b78;
        background: #f0f2f5;
    }

    .guest-actions {
        display: flex;
        align-items: center;
        gap: 5px;
        min-width: 150px;
    }

    .guest-actions form {
        margin: 0;
        display: inline-flex;
    }

    .guest-action {
        display: inline-flex;
        width: 32px;
        height: 32px;
        padding: 0;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7ec;
        border-radius: 8px;
        background: #fff;
        color: #5d6470;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        transition: all .15s ease;
    }

    .guest-action:hover {
        transform: translateY(-1px);
    }

    .guest-action-view:hover {
        color: #2459a9;
        background: #edf4ff;
        border-color: #d6e5ff;
    }

    .guest-action-edit:hover {
        color: #7652b5;
        background: #f5f0ff;
        border-color: #e6dbff;
    }

    .guest-action-checkin:hover {
        color: #fff;
        background: #168653;
        border-color: #168653;
    }

    .guest-action-undo:hover {
        color: #936200;
        background: #fff6dc;
        border-color: #f2df9c;
    }

    .guest-action-delete:hover {
        color: #b42332;
        background: #fff0f0;
        border-color: #ffd4d7;
    }

    .guest-empty-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border-radius: 18px;
        background: #f4f5f7;
        color: #858b97;
        font-size: 25px;
    }

    .guest-pagination {
        display: flex;
        justify-content: flex-end;
        padding: 18px 22px;
        border-top: 1px solid #f0f1f4;
    }

    .guest-pagination nav p {
        margin-bottom: 0;
    }

    @media (max-width: 767.98px) {
        .guest-header {
            align-items: flex-start;
        }

        .guest-add-btn {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        .guest-panel-heading,
        .guest-list-toolbar {
            padding: 15px;
        }

        .guest-table thead th,
        .guest-table tbody td {
            padding: 12px;
        }

        .guest-pagination {
            justify-content: center;
            padding: 15px 10px;
        }
    }
</style>
@endsection
