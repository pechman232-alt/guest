<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('wedding.app_name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/guest-pages.css') }}">
    <style>
        :root { --navy:#17233d; --red:#b51f36; --paper:#f5f7fb; }
        body { background:var(--paper); color:#202b3c; font-family:system-ui,-apple-system,"Segoe UI",sans-serif; }
        .sidebar { background:var(--navy); min-height:100vh; color:#fff; }
        .brand { font-weight:800; letter-spacing:.2px; }
        .side-link { color:#d9e0ed; text-decoration:none; display:flex; gap:.7rem; align-items:center; padding:.75rem .9rem; border-radius:.7rem; margin:.2rem 0; }
        .side-link:hover,.side-link.active { background:#2a3856; color:#fff; }
        .main { padding:1.5rem; }
        .topbar,.panel,.stat-card { background:#fff; border:1px solid #e8edf4; border-radius:1rem; box-shadow:0 5px 22px rgba(24,39,75,.04); }
        .stat-card { padding:1.15rem; height:100%; }
        .stat-icon { width:44px;height:44px;border-radius:12px;display:grid;place-items:center;background:#fce9ed;color:var(--red);font-size:1.2rem; }
        .muted { color:#788398; }
        .btn-primary { background:var(--red); border-color:var(--red); }
        .btn-primary:hover { background:#94172b; border-color:#94172b; }
        .table thead th { color:#69758a; font-size:.82rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
        .kh { font-family:system-ui,"Noto Sans Khmer","Khmer OS System",sans-serif; }
        @media(max-width:767px){.sidebar{min-height:auto}.main{padding:1rem}.side-nav{display:flex;flex-wrap:wrap}.side-link{padding:.5rem}}
    </style>
</head>
<body class="{{ app()->getLocale() === 'km' ? 'kh' : '' }}">
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <div class="brand fs-5 mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>{{ __('wedding.app_name') }}</div>
            <div class="small text-white-50 mb-4">{{ __('wedding.subtitle') }}</div>
            <nav class="side-nav">
                <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid"></i>{{ __('wedding.dashboard') }}</a>
                <a class="side-link {{ request()->routeIs('guests.*') ? 'active' : '' }}" href="{{ route('guests.index') }}"><i class="bi bi-people"></i>{{ __('wedding.guests') }}</a>
                <a class="side-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><i class="bi bi-bar-chart"></i>{{ __('wedding.reports') }}</a>
            </nav>
            <div class="small text-white-50 mt-5">Wedding day • Guest desk</div>
        </aside>
        <main class="col-md-9 col-lg-10 main">
            <div class="topbar d-flex justify-content-between align-items-center flex-wrap gap-3 p-3 mb-4">
                <div>
                    <div class="fw-bold">@yield('page_heading', __('wedding.dashboard'))</div>
                    <div class="small muted">{{ now()->format('l, d M Y') }}</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('language.switch', 'km') }}" class="btn btn-sm {{ app()->getLocale()==='km' ? 'btn-dark' : 'btn-outline-secondary' }}">ខ្មែរ</a>
                    <a href="{{ route('language.switch', 'en') }}" class="btn btn-sm {{ app()->getLocale()==='en' ? 'btn-dark' : 'btn-outline-secondary' }}">English</a>
                    <span class="rounded-circle bg-light px-3 py-2"><i class="bi bi-person"></i></span>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger"><strong>{{ __('wedding.fix_errors') }}</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @yield('content')
            <div class="text-center muted small mt-4">Wedding Guest Management System · Laravel</div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
