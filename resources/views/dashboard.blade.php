
@extends('layouts.app')

@section('title', __('wedding.dashboard').' | '.__('wedding.app_name'))
@section('page_heading', __('wedding.dashboard'))

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">{{ __('wedding.welcome') }}</h3>
        <div class="muted">{{ __('wedding.dashboard_desc') }}</div>
    </div>

    <a href="{{ route('guests.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        {{ __('wedding.add_guest') }}
    </a>
</div>

{{-- Dashboard Statistics --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="muted small">{{ __('wedding.registered_guests') }}</div>
                    <div class="fs-2 fw-bold">{{ $total }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="muted small">{{ __('wedding.checked_in') }}</div>
                    <div class="fs-2 fw-bold">{{ $checkedIn }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="muted small">{{ __('wedding.expected_people') }}</div>
                    <div class="fs-2 fw-bold">{{ $expectedPeople }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-person-hearts"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="muted small">{{ __('wedding.arrived_people') }}</div>
                    <div class="fs-2 fw-bold">{{ $arrivedPeople }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-door-open"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Guests --}}
<div class="panel p-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">{{ __('wedding.recent_guests') }}</h5>

        <a href="{{ route('guests.index') }}" class="text-decoration-none">
            {{ __('wedding.view_all') }}
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>{{ __('wedding.name') }}</th>
                    <th>{{ __('wedding.side') }}</th>
                    <th>{{ __('wedding.table') }}</th>
                    <th>{{ __('wedding.people') }}</th>
                    <th>{{ __('wedding.status') }}</th>
                    <th>{{ __('wedding.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentGuests as $guest)
                    <tr>
                        <td class="fw-semibold">
                            {{ $guest->full_name }}
                            @if($guest->phone)
                                <div class="small muted">{{ $guest->phone }}</div>
                            @endif
                        </td>

                        <td>
                            {{ __('wedding.'.$guest->guest_side) }}
                        </td>

                        <td>{{ $guest->table_number ?: '—' }}</td>

                        <td>{{ $guest->guest_count }}</td>

                        <td>
                            <span class="badge {{ $guest->checked_in_at ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $guest->checked_in_at
                                    ? __('wedding.checked_in')
                                    : __('wedding.not_arrived') }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('guests.show', $guest) }}"
                               class="btn btn-sm btn-outline-secondary">
                                {{ __('wedding.view') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center muted py-4">
                            {{ __('wedding.no_guests') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
