@extends('layouts.app')
@section('content')
<h2 style="color: var(--ink);">Training data export</h2>
<p style="font-size:13px; color:#4a5568; max-width:640px;">
    Every row here has already been through the PII scrubber — names, emails, phone numbers, locations, links,
    company names, and school names are all stripped. What's left is wording your AI can learn from:
    summaries, job-title phrasing, achievement bullets, and degree titles.
</p>

<div class="card" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div><strong>{{ $pendingCount }}</strong> opted-in resume(s) not exported yet.</div>
    <div style="display:flex; gap:10px;">
        <form method="POST" action="/admin/training/run">
            @csrf
            <button class="btn btn-outline">Run scrub now</button>
        </form>
        <a href="/admin/training/download" class="btn btn-gold">Download .jsonl</a>
    </div>
</div>

<div class="card">
    <table>
        <thead><tr><th>Resume ID</th><th>Preview</th><th>Created</th></tr></thead>
        <tbody>
        @foreach($exports as $ex)
            <tr>
                <td>#{{ $ex->resume_id }}</td>
                <td>{{ \Illuminate\Support\Str::limit($ex->scrubbed_text, 80) }}</td>
                <td>{{ $ex->created_at->format('d M Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $exports->links() }}
</div>
@endsection
