@extends('layouts.app')
@section('content')
<div class="auth-screen">
    <div class="auth-side">
        <div class="eyebrow"></div>
        <h1>Build a Brighter Career</h1>
        <p class="lede">Create professional resumes in minutes with beautiful templates.</p>

        <div class="auth-feature">
            <div class="icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="4" y="2" width="16" height="20" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 7h8M8 11h8M8 15h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <span>Professional templates</span>
        </div>
        <div class="auth-feature">
            <div class="icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
            </div>
            <span>AI-powered suggestions</span>
        </div>
        <div class="auth-feature">
            <div class="icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="1.8"/></svg>
            </div>
            <span>Your data stays private</span>
        </div>
    </div>

    <div class="auth-form-side">
        <span class="auth-top-link">Don't have an account? <a href="/register">Create one</a></span>
        <div class="auth-form-wrap">
            <div class="auth-brand">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="4" y="2" width="16" height="20" rx="2" stroke="#152238" stroke-width="1.8"/><path d="M8 7h8M8 11h8M8 15h5" stroke="#152238" stroke-width="1.8" stroke-linecap="round"/></svg>
                Resume Builder
            </div>

            <h2>Welcome back</h2>
            <p class="sub">Log in to your Resume Builder account</p>

            <form method="POST" action="/login">
                @csrf
                @error('email')<div class="error">{{ $message }}</div>@enderror

                <label class="field">Email
                    <div class="input-wrap">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.6"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    </div>
                </label>

                <label class="field">Password
                    <div class="input-wrap has-toggle">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="1.6"/></svg>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-visibility" onclick="const p=document.getElementById('password'); p.type = p.type==='password'?'text':'password';">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                        </button>
                    </div>
                </label>

                <div style="text-align:right; margin-top:-8px; margin-bottom:20px;">
                    <a href="#" style="font-size:13px; color:var(--gold-dark); font-weight:600;">Forgot password?</a>
                </div>

                <button class="btn btn-primary btn-block">Log in →</button>
            </form>

            <div class="divider-text">or continue with</div>
            <div class="oauth-row">
                <button type="button" class="oauth-btn" disabled title="Coming soon">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M21.35 11.1h-9.17v2.82h5.26c-.23 1.42-1.62 4.16-5.26 4.16-3.16 0-5.74-2.62-5.74-5.85s2.58-5.85 5.74-5.85c1.8 0 3 .77 3.69 1.43l2.52-2.43C16.9 3.6 14.8 2.6 12.18 2.6 6.98 2.6 2.8 6.78 2.8 12s4.18 9.4 9.38 9.4c5.42 0 9-3.8 9-9.15 0-.62-.07-1.09-.18-1.55Z"/></svg>
                    Google
                </button>
                <button type="button" class="oauth-btn" disabled title="Coming soon">
                    <svg width="16" height="16" viewBox="0 0 24 24"><rect x="2" y="2" width="9" height="9" fill="#F35325"/><rect x="13" y="2" width="9" height="9" fill="#81BC06"/><rect x="2" y="13" width="9" height="9" fill="#05A6F0"/><rect x="13" y="13" width="9" height="9" fill="#FFBA08"/></svg>
                    Microsoft
                </button>
            </div>

            <p style="text-align:center; font-size:13px; margin-top:24px; color:var(--muted);">
                New here? <a href="/register" style="color:var(--gold-dark); font-weight:700;">Create an account</a>
            </p>
        </div>
    </div>
</div>
@endsection
