<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Resume Builder')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

@auth
<div class="topbar no-print">
    <div class="container">
        <a href="/resumes" class="brand">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="4" y="2" width="16" height="20" rx="2" stroke="white" stroke-width="1.8"/>
                <path d="M8 7h8M8 11h8M8 15h5" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            Resume Builder
        </a>
        <div class="nav">
            <a href="/resumes" class="{{ request()->is('resumes') ? 'active' : '' }}">Home</a>
            <a href="/templates" class="{{ request()->is('templates') ? 'active' : '' }}">Templates</a>
            @if(auth()->user()->is_admin)
                <a href="/admin" style="color: var(--gold)">Admin</a>
            @endif
            <div class="user-chip">
                <div class="avatar-circle">{{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email, 0, 2)) }}</div>
                <span>{{ auth()->user()->email }}</span>
            </div>
            <form action="/logout" method="POST" style="display:inline">
                @csrf
                <button class="btn btn-outline btn-sm" style="border-color: rgba(255,255,255,.3); color: white;">Log out</button>
            </form>
        </div>
    </div>
</div>
@endauth

<div class="container" style="padding: 24px 20px;">
    @if(session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif
    @yield('content')
</div>

@yield('scripts')
</body>
</html>
