@extends('layouts.app')
@section('content')
<div class="center-screen">
    <form method="POST" action="/resumes/import" enctype="multipart/form-data" class="card" style="width: 420px;">
        @csrf
        <h2 style="margin-top:0; color: var(--ink);">Upload an existing resume</h2>
        <p style="font-size:13px; color:#4a5568;">PDF, DOCX, or TXT. We'll read it and fill in the resume fields for you — you can edit anything after.</p>
        @error('resume_file')<div class="error">{{ $message }}</div>@enderror
        <label class="field">File
            <input type="file" name="resume_file" accept=".pdf,.docx,.doc,.txt" required>
        </label>
        <button class="btn btn-gold" style="width:100%; justify-content:center;">Upload &amp; extract</button>
    </form>
</div>
@endsection
