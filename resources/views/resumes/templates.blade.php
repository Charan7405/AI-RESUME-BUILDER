@extends('layouts.app')
@section('content')
<h2 style="color: var(--ink);">Templates</h2>

<div class="card">
    <h4 style="margin-top:0;">Available templates</h4>
    <table>
        <thead><tr><th>Name</th><th>Type</th></tr></thead>
        <tbody>
        @foreach($templates as $t)
            <tr><td>{{ $t->name }}</td><td>{{ $t->is_default ? 'Default' : 'Your custom template' }}</td></tr>
        @endforeach
        </tbody>
    </table>
    <p style="font-size:13px; color:#6b6b6b;">Pick any of these from the "Template" dropdown when editing a resume.</p>
</div>

<div class="card">
    <h4 style="margin-top:0;">Add your own template</h4>
    <p style="font-size:13px; color:#4a5568;">
        Paste HTML using these placeholders — they'll be swapped for the resume's real content:
        @verbatim
        <code>{{name}} {{title}} {{email}} {{phone}} {{location}} {{links}} {{summary}} {{skills}}</code>,
        and repeat blocks with
        <code>{{#experience}} {{role}} {{company}} {{period}} {{bullets_html}} {{/experience}}</code>
        and
        <code>{{#education}} {{school}} {{degree}} {{period}} {{/education}}</code>.
        @endverbatim
    </p>
    @error('name')<div class="error">{{ $message }}</div>@enderror
    @error('html')<div class="error">{{ $message }}</div>@enderror
    <form method="POST" action="/templates">
        @csrf
        <label class="field">Template name<input name="name" required></label>
        <label class="field">HTML<textarea name="html" rows="10" required placeholder="<h1>@{{name}}</h1> ..."></textarea></label>
        <button class="btn btn-gold">Save template</button>
    </form>
</div>
@endsection
