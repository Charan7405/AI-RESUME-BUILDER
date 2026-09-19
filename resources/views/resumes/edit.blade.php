@extends('layouts.app')
@section('title', 'Edit resume')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div style="display:flex; justify-content:flex-end; gap:10px; margin-bottom:16px;" class="no-print">
    <span id="save-status" style="font-size:13px; color:#6b6b6b; align-self:center;"></span>
    <button class="btn btn-outline" onclick="saveResume()">Save</button>
    <a class="btn btn-gold" href="/resumes/{{ $resume->id }}/pdf">Export PDF</a>
</div>

<div class="grid-2">
    <div class="no-print" style="display:flex; flex-direction:column; gap:20px;">

        <div class="card">
            <h4 style="margin-top:0;">Template</h4>
            <label class="field">Choose a template
                <select id="template_id">
                    <option value="">Default</option>
                    @foreach($templates as $t)
                        <option value="{{ $t->id }}" @selected($resume->template_id == $t->id)>{{ $t->name }}</option>
                    @endforeach
                </select>
            </label>
            <a href="/templates" style="font-size:13px;">Manage templates / add your own →</a>
        </div>

        <div class="card">
            <h4 style="margin-top:0;">Contact</h4>
            @php $contact = $resume->contact ?? []; @endphp
            <label class="field">Full name<input id="c_name" value="{{ $contact['name'] ?? '' }}"></label>
            <label class="field">Title<input id="c_title" value="{{ $contact['title'] ?? '' }}"></label>
            <label class="field">Email<input id="c_email" value="{{ $contact['email'] ?? '' }}"></label>
            <label class="field">Phone<input id="c_phone" value="{{ $contact['phone'] ?? '' }}"></label>
            <label class="field">Location<input id="c_location" value="{{ $contact['location'] ?? '' }}"></label>
            <label class="field">LinkedIn / portfolio<input id="c_links" value="{{ $contact['links'] ?? '' }}"></label>
        </div>

        <div class="card">
            <h4 style="margin-top:0;">Summary</h4>
            <textarea id="summary" rows="3" style="width:100%; padding:9px; border:1px solid var(--line); border-radius:8px;">{{ $resume->summary }}</textarea>
            <div style="margin-top:8px;">
                <button type="button" class="btn btn-outline" style="border-color:#B8860B66; color:#8a6608;" onclick="enhanceSummary()">Enhance with AI</button>
                <span id="summary-err" style="font-size:12px; color:#b91c1c;"></span>
            </div>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between;">
                <h4 style="margin-top:0;">Experience</h4>
                <button type="button" class="btn btn-outline" onclick="addExperience()">+ Add</button>
            </div>
            <div id="experience-list"></div>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between;">
                <h4 style="margin-top:0;">Education</h4>
                <button type="button" class="btn btn-outline" onclick="addEducation()">+ Add</button>
            </div>
            <div id="education-list"></div>
        </div>

        <div class="card">
            <h4 style="margin-top:0;">Skills</h4>
            <input id="skills" value="{{ implode(', ', $resume->skills ?? []) }}" placeholder="Comma separated">
        </div>

        <div class="card">
            <label style="display:flex; align-items:center; gap:8px; font-size:13px;">
                <input type="checkbox" id="consent_training" @checked($resume->consent_training)>
                Allow anonymized text from this resume (no personal details) to help train our AI. See <a href="/terms" target="_blank">Terms</a>.
            </label>
        </div>
    </div>

    <div>
        <div class="resume-preview" id="preview"></div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const RESUME_ID = {{ $resume->id }};
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

let experience = @json($resume->experience ?: []);
let education = @json($resume->education ?: []);

function el(html) {
    const t = document.createElement('template');
    t.innerHTML = html.trim();
    return t.content.firstElementChild;
}

function renderExperience() {
    const list = document.getElementById('experience-list');
    list.innerHTML = '';
    experience.forEach((exp, i) => {
        const row = el(`
            <div style="border:1px solid var(--line); border-radius:8px; padding:12px; margin-bottom:12px;">
                <div style="display:flex; gap:8px;">
                    <input placeholder="Role" data-f="role" style="flex:1; padding:7px; border-radius:6px; border:1px solid var(--line);" value="${escAttr(exp.role)}">
                    <input placeholder="Company" data-f="company" style="flex:1; padding:7px; border-radius:6px; border:1px solid var(--line);" value="${escAttr(exp.company)}">
                    <button type="button" class="btn btn-outline" data-remove>✕</button>
                </div>
                <input placeholder="Period" data-f="period" style="width:100%; margin-top:8px; padding:7px; border-radius:6px; border:1px solid var(--line);" value="${escAttr(exp.period)}">
                <textarea placeholder="One achievement per line" data-f="bullets" rows="3" style="width:100%; margin-top:8px; padding:7px; border-radius:6px; border:1px solid var(--line);">${escHtml(exp.bullets)}</textarea>
                <div style="margin-top:8px; display:flex; align-items:center; gap:8px;">
                    <button type="button" class="btn btn-outline" style="border-color:#B8860B66; color:#8a6608;" data-enhance>Enhance bullets</button>
                    <span class="ai-err" style="font-size:12px; color:#b91c1c;"></span>
                </div>
            </div>
        `);
        row.querySelectorAll('[data-f]').forEach(inp => {
            inp.addEventListener('input', () => { experience[i][inp.dataset.f] = inp.value; renderPreview(); });
        });
        row.querySelector('[data-remove]').addEventListener('click', () => { experience.splice(i, 1); renderExperience(); renderPreview(); });
        row.querySelector('[data-enhance]').addEventListener('click', () => enhanceBullets(i, row));
        list.appendChild(row);
    });
}

function renderEducation() {
    const list = document.getElementById('education-list');
    list.innerHTML = '';
    education.forEach((edu, i) => {
        const row = el(`
            <div style="border:1px solid var(--line); border-radius:8px; padding:12px; margin-bottom:12px;">
                <div style="display:flex; gap:8px;">
                    <input placeholder="School" data-f="school" style="flex:1; padding:7px; border-radius:6px; border:1px solid var(--line);" value="${escAttr(edu.school)}">
                    <button type="button" class="btn btn-outline" data-remove>✕</button>
                </div>
                <input placeholder="Degree" data-f="degree" style="width:100%; margin-top:8px; padding:7px; border-radius:6px; border:1px solid var(--line);" value="${escAttr(edu.degree)}">
                <input placeholder="Period" data-f="period" style="width:100%; margin-top:8px; padding:7px; border-radius:6px; border:1px solid var(--line);" value="${escAttr(edu.period)}">
            </div>
        `);
        row.querySelectorAll('[data-f]').forEach(inp => {
            inp.addEventListener('input', () => { education[i][inp.dataset.f] = inp.value; renderPreview(); });
        });
        row.querySelector('[data-remove]').addEventListener('click', () => { education.splice(i, 1); renderEducation(); renderPreview(); });
        list.appendChild(row);
    });
}

function addExperience() { experience.push({role:'', company:'', period:'', bullets:''}); renderExperience(); renderPreview(); }
function addEducation() { education.push({school:'', degree:'', period:''}); renderEducation(); renderPreview(); }

function escAttr(s) { return (s || '').replace(/"/g, '&quot;'); }
function escHtml(s) { return (s || '').replace(/</g, '&lt;'); }

function fieldVal(id) { return document.getElementById(id).value; }

function renderPreview() {
    const name = fieldVal('c_name'), title = fieldVal('c_title');
    const meta = [fieldVal('c_email'), fieldVal('c_phone'), fieldVal('c_location'), fieldVal('c_links')].filter(Boolean).join(' · ');
    let html = `<h1>${name}</h1><div class="role">${title}</div><div class="meta">${meta}</div>`;

    html += `<section><div class="section-title">Summary</div><p style="font-size:14px; line-height:1.6;">${escHtml(fieldVal('summary'))}</p></section>`;

    html += `<section><div class="section-title">Experience</div>`;
    experience.forEach(exp => {
        html += `<div style="margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between;">
                <strong style="font-size:14px;">${escHtml(exp.role)} · ${escHtml(exp.company)}</strong>
                <span style="font-size:12px; color:#8a8a8a; font-family:sans-serif;">${escHtml(exp.period)}</span>
            </div>
            <ul style="margin:4px 0 0; padding-left:18px;">
                ${(exp.bullets||'').split('\n').filter(Boolean).map(b => `<li style="font-size:14px; line-height:1.6;">${escHtml(b)}</li>`).join('')}
            </ul>
        </div>`;
    });
    html += `</section>`;

    html += `<section><div class="section-title">Education</div>`;
    education.forEach(edu => {
        html += `<div style="display:flex; justify-content:space-between; margin-bottom:6px;">
            <span style="font-size:14px;">${escHtml(edu.degree)}, ${escHtml(edu.school)}</span>
            <span style="font-size:12px; color:#8a8a8a; font-family:sans-serif;">${escHtml(edu.period)}</span>
        </div>`;
    });
    html += `</section>`;

    const skills = fieldVal('skills').split(',').map(s => s.trim()).filter(Boolean);
    html += `<section style="margin-bottom:0;"><div class="section-title">Skills</div><div style="display:flex; flex-wrap:wrap; gap:6px;">
        ${skills.map(s => `<span style="font-size:12px; padding:3px 9px; border-radius:20px; border:1px solid #B8860B55; font-family:sans-serif;">${escHtml(s)}</span>`).join('')}
    </div></section>`;

    document.getElementById('preview').innerHTML = html;
}

async function callAI(prompt) {
    const res = await fetch('/ai/enhance', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ prompt }),
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.error || 'AI request failed');
    return data.text;
}

async function enhanceSummary() {
    const errEl = document.getElementById('summary-err');
    errEl.textContent = '';
    try {
        const text = await callAI(`Rewrite this resume summary to be sharp and professional, under 40 words, no preamble:\n\n${fieldVal('summary')}`);
        if (text) { document.getElementById('summary').value = text; renderPreview(); }
    } catch (e) { errEl.textContent = e.message; }
}

async function enhanceBullets(i, row) {
    const errEl = row.querySelector('.ai-err');
    errEl.textContent = '';
    const exp = experience[i];
    try {
        const text = await callAI(`Rewrite these resume bullet points for a "${exp.role}" role at "${exp.company}". Strong action verbs, quantify impact where plausible, one point per line, no bullet symbols, no preamble:\n\n${exp.bullets}`);
        if (text) { exp.bullets = text; renderExperience(); renderPreview(); }
    } catch (e) { errEl.textContent = e.message; }
}

async function saveResume() {
    const payload = {
        contact: {
            name: fieldVal('c_name'), title: fieldVal('c_title'), email: fieldVal('c_email'),
            phone: fieldVal('c_phone'), location: fieldVal('c_location'), links: fieldVal('c_links'),
        },
        summary: fieldVal('summary'),
        experience, education,
        skills: fieldVal('skills').split(',').map(s => s.trim()).filter(Boolean),
        template_id: document.getElementById('template_id').value || null,
        consent_training: document.getElementById('consent_training').checked,
        _method: 'PUT',
    };
    const status = document.getElementById('save-status');
    status.textContent = 'Saving…';
    const res = await fetch(`/resumes/${RESUME_ID}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(payload),
    });
    status.textContent = res.ok ? 'Saved' : 'Failed to save';
    setTimeout(() => status.textContent = '', 2000);
}

document.querySelectorAll('#c_name,#c_title,#c_email,#c_phone,#c_location,#c_links,#summary,#skills').forEach(elm => {
    elm.addEventListener('input', renderPreview);
});

renderExperience();
renderEducation();
renderPreview();
</script>
@endsection
