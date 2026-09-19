<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::withCount('resumes')->latest()->get();
        $stats = [
            'total_users' => $users->count(),
            'total_resumes' => Resume::count(),
            'admins' => $users->where('is_admin', true)->count(),
        ];

        return view('admin.dashboard', compact('users', 'stats'));
    }
}
