@extends('layouts.app')
@section('content')
<div class="auth-screen">
    <div class="auth-side">
        <div class="eyebrow"></div>
        <h1>Start Your Journey</h1>
        <p class="lede">Create an account and discover a faster, smarter way to build your resume.</p>

        <div class="auth-feature">
            <div class="icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <span>Easy to use</span>
        </div>
        <div class="auth-feature">
            <div class="icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="4" y="2" width="16" height="20" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 7h8M8 11h8M8 15h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <span>Professional templates</span>
        </div>
        <div class="auth-feature">
            <div class="icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 20V10M10 20V4M17 20v-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <span>Stand out from the crowd</span>
        </div>
    </div>

    <div class="auth-form-side">
        <span class="auth-top-link">Already have an account? <a href="/login">Log in</a></span>
        <div class="auth-form-wrap">
            <div class="auth-brand">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="4" y="2" width="16" height="20" rx="2" stroke="#152238" stroke-width="1.8"/><path d="M8 7h8M8 11h8M8 15h5" stroke="#152238" stroke-width="1.8" stroke-linecap="round"/></svg>
                Resume Builder
            </div>

            <h2>Create your account</h2>
            <p class="sub">Join thousands of professionals building better opportunities.</p>

            <form method="POST" action="/register">
                @csrf
                @error('name')<div class="error">{{ $message }}</div>@enderror
                @error('email')<div class="error">{{ $message }}</div>@enderror
                @error('password')<div class="error">{{ $message }}</div>@enderror

                <label class="field">Full name
                    <div class="input-wrap">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-4 3.5-6 8-6s8 2 8 6" stroke="currentColor" stroke-width="1.6"/></svg>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                    </div>
                </label>

                <label class="field">Email
                    <div class="input-wrap">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 6h18v12H3z" stroke="currentColor" stroke-width="1.6"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                </label>

                <label class="field">Password
                    <div class="input-wrap has-toggle">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="1.6"/></svg>
                        <input type="password" name="password" id="password" placeholder="Create a password" required minlength="6">
                        <button type="button" class="toggle-visibility" onclick="const p=document.getElementById('password'); p.type = p.type==='password'?'text':'password';">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                        </button>
                    </div>
                </label>

                <label class="field">Confirm password
                    <div class="input-wrap has-toggle">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="1.6"/></svg>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" required minlength="6">
                        <button type="button" class="toggle-visibility" onclick="const p=document.getElementById('password_confirmation'); p.type = p.type==='password'?'text':'password';">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                        </button>
                    </div>
                </label>

                <button class="btn btn-gold btn-block">Create account →</button>
            </form>

            <div class="divider-text">or sign up with</div>
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

            <p style="text-align:center; font-size:12px; margin-top:24px; color:var(--muted);">
                By creating an account, you agree to our <a href="/terms" style="color:var(--gold-dark); font-weight:600;">Terms of Service</a> and Privacy Policy.
            </p>
        </div>
    </div>
</div>
@endsection
