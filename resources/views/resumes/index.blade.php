@extends('layouts.app')
@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
    <h2 style="margin:0; color: var(--ink);">Your resumes</h2>
    <div style="display:flex; gap:10px;">
        <a href="/resumes/import" class="btn btn-outline">Upload existing resume</a>
        <form method="POST" action="/resumes" style="display:inline">
            @csrf
            <button class="btn btn-gold">+ New resume</button>
        </form>
    </div>
</div>

@if($resumes->isEmpty())
    <div class="card">No resumes yet — create one or upload an existing resume to get started.</div>
@else
    <div class="card">
        <table>
            <thead><tr><th>Title</th><th>Last updated</th><th></th></tr></thead>
            <tbody>
            @foreach($resumes as $resume)
                <tr>
                    <td><a href="/resumes/{{ $resume->id }}/edit">{{ $resume->title }}</a></td>
                    <td>{{ $resume->updated_at->diffForHumans() }}</td>
                    <td>
                        <form method="POST" action="/resumes/{{ $resume->id }}" onsubmit="return confirm('Delete this resume?')" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger" style="padding:6px 10px;">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
