<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $currentKey = AppSetting::get('gemini_api_key');
        $preview = $currentKey ? substr($currentKey, 0, 6) . '…' . substr($currentKey, -4) : null;

        return view('admin.settings', compact('preview'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'gemini_api_key' => ['nullable', 'string', 'max:255'],
        ]);

        if (! empty($data['gemini_api_key'])) {
            AppSetting::set('gemini_api_key', $data['gemini_api_key']);
        }

        return redirect('/admin/settings')->with('status', 'Saved.');
    }
}
