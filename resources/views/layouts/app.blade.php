<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AI Resume Builder')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

@auth
<div class="topbar no-print">
    <div class="container">
        <a href="/resumes" class="brand">Resume Builder</a>
        <div class="nav">
            <span style="opacity:.7">{{ auth()->user()->email }}</span>
            @if(auth()->user()->is_admin)
                <a href="/admin" style="color: var(--gold)">Admin</a>
            @endif
            <a href="/templates">Templates</a>
            <form action="/logout" method="POST" style="display:inline">
                @csrf
                <button class="btn btn-outline" style="border-color: rgba(255,255,255,.3); color: white; padding: 6px 12px;">Log out</button>
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
