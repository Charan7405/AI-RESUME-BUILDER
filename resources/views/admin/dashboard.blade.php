@extends('layouts.app')
@section('content')
<h2 style="color: var(--ink);">Admin</h2>
<div style="display:flex; gap:16px; margin-bottom:20px; flex-wrap:wrap;">
    <div class="card" style="flex:1; min-width:140px;"><div style="font-size:26px; font-weight:700;">{{ $stats['total_users'] }}</div><div style="font-size:12px; color:#6b6b6b;">Users</div></div>
    <div class="card" style="flex:1; min-width:140px;"><div style="font-size:26px; font-weight:700;">{{ $stats['total_resumes'] }}</div><div style="font-size:12px; color:#6b6b6b;">Resumes</div></div>
    <div class="card" style="flex:1; min-width:140px;"><div style="font-size:26px; font-weight:700;">{{ $stats['admins'] }}</div><div style="font-size:12px; color:#6b6b6b;">Admins</div></div>
</div>

<div style="display:flex; gap:10px; margin-bottom:20px;">
    <a href="/admin/settings" class="btn btn-outline">API key settings</a>
    <a href="/admin/training" class="btn btn-outline">Training data export</a>
</div>

<div class="card">
    <h4 style="margin-top:0;">All users</h4>
    <table>
        <thead><tr><th>Email</th><th>Name</th><th>Resumes</th><th>Joined</th><th>Role</th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->email }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->resumes_count }}</td>
                <td>{{ $u->created_at->format('d M Y') }}</td>
                <td>{{ $u->is_admin ? 'Admin' : 'User' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
