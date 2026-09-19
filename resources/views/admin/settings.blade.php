@extends('layouts.app')
@section('content')
<h2 style="color: var(--ink);">Settings</h2>
<div class="card" style="max-width:480px;">
    <h4 style="margin-top:0;">Gemini API key</h4>
    @if($preview)
        <p style="font-size:13px; color:#4a5568;">Currently saved: <code>{{ $preview }}</code></p>
    @endif
    <form method="POST" action="/admin/settings">
        @csrf
        <label class="field">New key<input name="gemini_api_key" placeholder="Paste Gemini API key"></label>
        <button class="btn btn-gold">Save</button>
    </form>
    <p style="font-size:12px; color:#6b6b6b; margin-top:14px;">
        Stored in the database, read only by the server when it calls Gemini on a user's behalf. Never sent to the browser.
    </p>
</div>
@endsection
