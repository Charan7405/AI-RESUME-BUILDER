@extends('layouts.app')
@section('content')
<div class="center-screen">
    <form method="POST" action="/register" class="card" style="width: 360px;">
        @csrf
        <h2 style="margin-top:0; font-family: Georgia, serif; color: var(--ink);">Create account</h2>
        @error('name')<div class="error">{{ $message }}</div>@enderror
        @error('email')<div class="error">{{ $message }}</div>@enderror
        @error('password')<div class="error">{{ $message }}</div>@enderror
        <label class="field">Name
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </label>
        <label class="field">Email
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        <label class="field">Password
            <input type="password" name="password" required minlength="6">
        </label>
        <label class="field">Confirm password
            <input type="password" name="password_confirmation" required minlength="6">
        </label>
        <button class="btn btn-primary" style="width:100%; justify-content:center;">Sign up</button>
        <p style="text-align:center; font-size:13px; margin-top:14px;">
            Already have an account? <a href="/login">Log in</a>
        </p>
    </form>
</div>
@endsection
