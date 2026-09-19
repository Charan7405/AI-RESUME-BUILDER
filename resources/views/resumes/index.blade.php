@extends('layouts.app')
@section('content')

<div class="hero-banner">
    <div>
        <div class="eyebrow">Welcome back</div>
        <h1>Create a resume that gets you hired</h1>
        <p>Build, edit, and manage professional resumes with ease.</p>
        <div class="hero-actions">
            <form method="POST" action="/resumes" style="display:inline">
                @csrf
                <button class="btn btn-gold">+ New resume</button>
            </form>
            <a href="/resumes/import" class="btn btn-outline" style="background:white;">↑ Upload existing resume</a>
        </div>
    </div>
</div>

<div class="dash-grid">
    <div>
        <div class="card card-flush">
            <div style="padding:20px 24px 4px; display:flex; justify-content:space-between; align-items:center;">
                <h3 style="margin:0; color:var(--ink); font-size:17px;">Your resumes</h3>
            </div>

            @if($resumes->isEmpty())
                <div style="padding: 24px;">
                    <p style="color:var(--muted); margin:0;">No resumes yet — create one or upload an existing resume to get started.</p>
                </div>
            @else
                <table style="margin-top:8px;">
                    <thead><tr><th style="padding-left:24px;">Title</th><th>Last updated</th><th style="padding-right:24px;">Actions</th></tr></thead>
                    <tbody>
                    @foreach($resumes as $resume)
                        <tr>
                            <td style="padding-left:24px; font-weight:600;">
                                <a href="/resumes/{{ $resume->id }}/edit">{{ $resume->title }}</a>
                            </td>
                            <td style="color:var(--muted);">{{ $resume->updated_at->diffForHumans() }}</td>
                            <td style="padding-right:24px;">
                                <div style="display:flex; gap:8px;">
                                    <a href="/resumes/{{ $resume->id }}/edit" class="btn btn-outline btn-sm">Edit</a>
                                    <a href="/resumes/{{ $resume->id }}/pdf" class="btn btn-outline btn-sm">Download</a>
                                    <form method="POST" action="/resumes/{{ $resume->id }}" onsubmit="return confirm('Delete this resume?')" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="height:8px;"></div>
            @endif
        </div>
    </div>

    <div>
        <div class="card">
            <h4 style="margin:0 0 16px; color:var(--ink); font-size:15px;">Your activity</h4>
            <div class="stat-card" style="padding-left:0; padding-right:0;">
                <div class="icon-badge green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="4" y="2" width="16" height="20" rx="2" stroke="currentColor" stroke-width="1.8"/></svg>
                </div>
                <div>
                    <div class="num">{{ $resumes->count() }}</div>
                    <div class="label">{{ $resumes->count() === 1 ? 'Resume' : 'Resumes' }}</div>
                </div>
            </div>
            @if($resumes->isNotEmpty())
            <div class="stat-card" style="padding-left:0; padding-right:0;">
                <div class="icon-badge gold">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                </div>
                <div>
                    <div class="num">{{ $resumes->first()->updated_at->diffForHumans() }}</div>
                    <div class="label">Last updated</div>
                </div>
            </div>
            @endif
        </div>

        <div class="card">
            <h4 style="margin:0 0 16px; color:var(--ink); font-size:15px;">Quick actions</h4>
            <form method="POST" action="/resumes">
                @csrf
                <button type="submit" class="quick-action gold-tint" style="width:100%; border:none; cursor:pointer; text-align:left;">
                    <div class="icon-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="var(--gold-dark)" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <strong>Create new resume</strong>
                        <small>Start from scratch</small>
                    </div>
                </button>
            </form>
            <a href="/resumes/import" class="quick-action blue-tint">
                <div class="icon-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 3v12M7 10l5 5 5-5M5 21h14" stroke="#2b5faa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <strong>Upload and extract</strong>
                    <small>Upload PDF, DOCX or TXT</small>
                </div>
            </a>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #e9f1fb, #f3f8fd); border: none;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z" stroke="#2b5faa" stroke-width="1.8" stroke-linejoin="round"/></svg>
                <strong style="color:var(--ink); font-size:14px;">Build a better future</strong>
            </div>
            <p style="font-size:13px; color:var(--muted); margin:0 0 8px;">Use professional templates, get AI-powered suggestions, and create a resume that stands out.</p>
            <a href="/templates" style="font-size:13px; font-weight:700; color:#2b5faa;">Browse templates →</a>
        </div>
    </div>
</div>
@endsection
