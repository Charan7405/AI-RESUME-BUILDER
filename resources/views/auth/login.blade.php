@extends('layouts.app')
@section('content')
<div class="center-screen">
    <form method="POST" action="/login" class="card" style="width: 360px;">
        @csrf
        <h2 style="margin-top:0; font-family: Georgia, serif; color: var(--ink);">Log in</h2>
        @error('email')<div class="error">{{ $message }}</div>@enderror
        <label class="field">Email
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>
        <label class="field">Password
            <input type="password" name="password" required>
        </label>
        <button class="btn btn-primary" style="width:100%; justify-content:center;">Log in</button>
        <p style="text-align:center; font-size:13px; margin-top:14px;">
            New here? <a href="/register">Create an account</a>
        </p>
    </form>
</div>
@endsection
