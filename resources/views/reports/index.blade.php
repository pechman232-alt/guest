
@extends('layouts.app')

@section('title', __('wedding.reports'))
@section('page_heading', __('wedding.reports'))

@section('content')
<div class="report-page">

    {{-- Header --}}
    <div class="report-header">
        <div>
            <div class="report-eyebrow">
                <i class="bi bi-bar-chart-line me-1"></i>
                WEDDING ANALYTICS
            </div>
            <h2 class="report-title">{{ __('wedding.reports') }}</h2>
            <p class="report-subtitle mb-0">
                {{ __('wedding.reports_desc') }}
            </p>
        </div>

        <a href="{{ route('reports.csv') }}" class="report-export-btn">
            <i class="bi bi-download me-2"></i>
            {{ __('wedding.export_csv') }}
        </a>
    </div>

    @php
        $total = (int) ($totalGuests ?? 0);
        $checked = (int) ($checkedIn ?? 0);
        $notArrivedCount = (int) ($notArrived ?? 0);
        $expected = (int) ($peopleExpected ?? 0);
        $arrived = (int) ($peopleArrived ?? 0);

        $attendanceRate = $expected > 0
            ? min(100, round(($arrived / $expected) * 100))
            : 0;

        $guestStats = [
            [
                'label' => __('wedding.registered_guests'),
                'value' => $total,
                'icon' => 'bi-people',
                'style' => 'red',
                'caption' => __('wedding.guest_list'),
            ],
            [
                'label' => __('wedding.checked_in'),
                'value' => $checked,
                'icon' => 'bi-check-circle',
                'style' => 'green',
                'caption' => __('wedding.arrived_people'),
            ],
            [
                'label' => __('wedding.not_arrived'),
                'value' => $notArrivedCount,
                'icon' => 'bi-clock-history',
                'style' => 'orange',
                'caption' => __('wedding.status'),
            ],
            [
                'label' => __('wedding.expected_people'),
                'value' => $expected,
                'icon' => 'bi-people-fill',
                'style' => 'blue',
                'caption' => __('wedding.people'),
            ],
        ];
    @endphp

    {{-- KPI Cards --}}
    <div class="row g-3 mb-4">
        @foreach ($guestStats as $stat)
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="report-stat-card h-100">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="report-stat-label">{{ $stat['label'] }}</div>
                            <div class="report-stat-value">
                                {{ number_format($stat['value']) }}
                            </div>
                        </div>

                        <div class="report-stat-icon {{ $stat['style'] }}">
                            <i class="bi {{ $stat['icon'] }}"></i>
                        </div>
                    </div>

                    <div class="report-stat-footer">
                        <i class="bi bi-dot"></i>
                        {{ $stat['caption'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Attendance Overview --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-7">
            <div class="report-card h-100">
                <div class="report-card-header">
                    <div>
                        <h5 class="report-card-title">
                            {{ __('wedding.arrived_people') }}
                        </h5>
                        <p class="report-card-description mb-0">
                            {{ __('wedding.expected_people') }}
                        </p>
                    </div>

                    <div class="report-heading-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>

                <div class="attendance-overview">
                    <div class="attendance-number">
                        <span>{{ number_format($arrived) }}</span>
                        <small>/ {{ number_format($expected) }}</small>
                    </div>

                    <div class="attendance-rate">{{ $attendanceRate }}%</div>
                </div>

                <div
                    class="progress report-progress"
                    role="progressbar"
                    aria-label="{{ __('wedding.arrived_people') }}"
                    aria-valuenow="{{ $attendanceRate }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    <div
                        class="progress-bar"
                        style="width: {{ $attendanceRate }}%"
                    ></div>
                </div>

                <div class="attendance-legend">
                    <span>
                        <span class="legend-dot arrived-dot"></span>
                        {{ __('wedding.arrived_people') }}
                    </span>
                    <span>
                        <span class="legend-dot remaining-dot"></span>
                        {{ __('wedding.not_arrived') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="report-card h-100">
                <div class="report-card-header">
                    <div>
                        <h5 class="report-card-title">
                            {{ __('wedding.checked_in') }}
                        </h5>
                        <p class="report-card-description mb-0">
                            {{ __('wedding.registered_guests') }}
                        </p>
                    </div>

                    <div class="report-heading-icon green-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>

                <div class="checkin-summary">
                    <div class="checkin-summary-item">
                        <span class="checkin-summary-dot is-checked"></span>
                        <span>{{ __('wedding.checked_in') }}</span>
                        <strong>{{ number_format($checked) }}</strong>
                    </div>

                    <div class="checkin-summary-item">
                        <span class="checkin-summary-dot is-pending"></span>
                        <span>{{ __('wedding.not_arrived') }}</span>
                        <strong>{{ number_format($notArrivedCount) }}</strong>
                    </div>
                </div>

                <div class="checkin-total">
                    <span>{{ __('wedding.registered_guests') }}</span>
                    <strong>{{ number_format($total) }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Breakdown by Side --}}
    <div class="report-card">
        <div class="report-card-header">
            <div>
                <h5 class="report-card-title">{{ __('wedding.by_side') }}</h5>
                <p class="report-card-description mb-0">
                    {{ __('wedding.reports_desc') }}
                </p>
            </div>

            <div class="report-heading-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table report-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>{{ __('wedding.side') }}</th>
                        <th class="text-end">{{ __('wedding.registered_guests') }}</th>
                        <th class="text-end">{{ __('wedding.expected_people') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bySide ?? [] as $row)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="side-indicator"></span>
                                    <span class="fw-semibold">
                                        {{ __('wedding.' . $row->guest_side) }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-end">
                                <span class="report-number">
                                    {{ number_format((int) $row->total) }}
                                </span>
                            </td>

                            <td class="text-end">
                                <span class="report-number">
                                    {{ number_format((int) ($row->people ?? 0)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="report-empty-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>
                                <div class="fw-semibold mt-3">
                                    {{ __('wedding.no_guests') }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    .report-page {
        --report-red: #b7192f;
        --report-red-light: #fff0f2;
        --report-text: #252934;
        --report-muted: #7a8190;
        --report-border: #e9ecf1;
        color: var(--report-text);
    }

    .report-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 26px;
    }

    .report-eyebrow {
        color: var(--report-red);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.6px;
        margin-bottom: 8px;
    }

    .report-title {
        font-size: clamp(24px, 3vw, 31px);
        font-weight: 800;
        letter-spacing: -.8px;
        margin-bottom: 7px;
    }

    .report-subtitle,
    .report-card-description {
        color: var(--report-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .report-export-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 0 16px;
        border-radius: 10px;
        background: var(--report-red);
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
    }

    .report-export-btn:hover {
        color: #fff;
        background: #971429;
        transform: translateY(-1px);
    }

    .report-stat-card,
    .report-card {
        background: #fff;
        border: 1px solid var(--report-border);
        border-radius: 15px;
        box-shadow: 0 3px 12px rgba(25, 32, 48, .035);
    }

    .report-stat-card {
        padding: 20px;
    }

    .report-stat-label {
        color: var(--report-muted);
        font-size: 12px;
        font-weight: 650;
        margin-bottom: 12px;
    }

    .report-stat-value {
        color: var(--report-text);
        font-size: clamp(27px, 3vw, 34px);
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.1;
        overflow-wrap: anywhere;
    }

    .report-stat-icon,
    .report-heading-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 43px;
        height: 43px;
        border-radius: 12px;
        font-size: 19px;
    }

    .report-stat-icon.red {
        background: #fff0f2;
        color: #b7192f;
    }

    .report-stat-icon.green,
    .green-icon {
        background: #eaf8f0;
        color: #188253;
    }

    .report-stat-icon.orange {
        background: #fff5e5;
        color: #a96708;
    }

    .report-stat-icon.blue {
        background: #edf4ff;
        color: #3165ad;
    }

    .report-stat-footer {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 19px;
        padding-top: 12px;
        border-top: 1px solid #f0f1f4;
        color: var(--report-muted);
        font-size: 11px;
    }

    .report-stat-footer i {
        font-size: 17px;
        color: #a0a6b1;
    }

    .report-card {
        overflow: hidden;
    }

    .report-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 21px 22px;
        border-bottom: 1px solid #f0f1f4;
    }

    .report-card-title {
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .report-heading-icon {
        background: var(--report-red-light);
        color: var(--report-red);
    }

    .attendance-overview {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 10px;
        padding: 25px 22px 16px;
    }

    .attendance-number {
        display: flex;
        align-items: baseline;
        gap: 7px;
        flex-wrap: wrap;
    }

    .attendance-number span {
        font-size: 35px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .attendance-number small {
        color: var(--report-muted);
        font-size: 14px;
    }

    .attendance-rate {
        color: #188253;
        font-size: 24px;
        font-weight: 800;
    }

    .report-progress {
        height: 9px;
        margin: 0 22px;
        width: calc(100% - 44px);
        background: #edf0f3;
        border-radius: 99px;
        overflow: hidden;
    }

    .report-progress .progress-bar {
        background: #188253;
        border-radius: 99px;
        transition: width .4s ease;
    }

    .attendance-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        padding: 17px 22px 23px;
        color: var(--report-muted);
        font-size: 12px;
    }

    .attendance-legend span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .legend-dot,
    .checkin-summary-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .arrived-dot,
    .is-checked {
        background: #188253;
    }

    .remaining-dot,
    .is-pending {
        background: #e3a332;
    }

    .checkin-summary {
        padding: 13px 22px;
    }

    .checkin-summary-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 0;
        color: #626977;
        font-size: 13px;
        border-bottom: 1px solid #f0f1f4;
    }

    .checkin-summary-item strong {
        margin-left: auto;
        color: var(--report-text);
        font-size: 15px;
    }

    .checkin-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 22px;
        background: #fafbfc;
        color: var(--report-muted);
        font-size: 12px;
    }

    .checkin-total strong {
        color: var(--report-text);
        font-size: 17px;
    }

    .report-table {
        font-size: 13px;
    }

    .report-table thead th {
        padding: 15px 22px;
        background: #f8f9fb;
        border-bottom: 1px solid var(--report-border);
        color: #6e7582;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .35px;
    }

    .report-table tbody td {
        padding: 17px 22px;
        border-bottom: 1px solid #f0f1f4;
    }

    .report-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .report-table tbody tr:hover {
        background: #fdfbfc;
    }

    .side-indicator {
        width: 9px;
        height: 9px;
        border-radius: 3px;
        background: var(--report-red);
        flex-shrink: 0;
    }

    .report-number {
        display: inline-block;
        min-width: 35px;
        color: var(--report-text);
        font-weight: 750;
    }

    .report-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        margin: auto;
        border-radius: 15px;
        background: #f3f5f7;
        color: #858c99;
        font-size: 24px;
    }

    @media (max-width: 767.98px) {
        .report-header {
            align-items: flex-start;
        }

        .report-export-btn {
            width: 100%;
        }

        .report-stat-card {
            padding: 16px;
        }

        .report-card-header {
            padding: 17px;
        }

        .attendance-overview {
            padding: 21px 17px 14px;
        }

        .report-progress {
            margin-right: 17px;
            margin-left: 17px;
            width: calc(100% - 34px);
        }

        .attendance-legend {
            padding: 16px 17px 20px;
        }

        .report-table thead th,
        .report-table tbody td {
            padding: 13px 15px;
        }
    }
</style>
@endsection
