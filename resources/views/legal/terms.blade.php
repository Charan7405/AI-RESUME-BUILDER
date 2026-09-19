@extends('layouts.app')
@section('content')
<div class="card" style="max-width:720px; margin:0 auto;">
    <h2 style="color: var(--ink); margin-top:0;">Terms & Conditions — Data Use</h2>
    <p style="font-size:14px; line-height:1.7;">Last updated {{ date('d M Y') }}.</p>

    <h4>What we collect</h4>
    <p style="font-size:14px; line-height:1.7;">
        When you use this resume builder, we store the resume content you enter or upload: your contact details,
        summary, work experience, education, and skills.
    </p>

    <h4>What may be used to improve our AI</h4>
    <p style="font-size:14px; line-height:1.7;">
        If you opt in (the checkbox in the resume editor), we take a copy of your resume and remove every
        identifying detail first — your name, email, phone number, location, links, employer names, and school
        names are all stripped out. What remains — the wording of your summary, job-title phrasing, and
        achievement sentences — may be used as training text to improve our AI features. This text alone
        cannot be traced back to you.
    </p>

    <h4>What is never used for training</h4>
    <p style="font-size:14px; line-height:1.7;">
        Your name, email, phone number, address, links, employer names, and school names are excluded from
        training data entirely. Your account credentials (password) are never used for anything beyond logging
        you in, and are stored hashed, not in plain text.
    </p>

    <h4>Your control</h4>
    <p style="font-size:14px; line-height:1.7;">
        The training checkbox is off unless you turn it on, and you can turn it off again at any time from the
        resume editor. Turning it off stops future exports of that resume; it does not retroactively delete
        text already exported before you opted out — contact us if you'd like a prior export removed.
    </p>

    <h4>Uploaded files</h4>
    <p style="font-size:14px; line-height:1.7;">
        If you upload an existing resume to auto-fill the form, the file is read once to extract structured
        data and is not itself retained beyond that process.
    </p>
</div>
@endsection
