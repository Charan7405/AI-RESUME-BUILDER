<?php

namespace App\Http\Controllers;

use App\Models\ResumeTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = ResumeTemplate::query()
            ->where('is_default', true)
            ->orWhere('created_by', $request->user()->id)
            ->latest()
            ->get();

        return view('resumes.templates', compact('templates'));
    }

    /**
     * User provides their own template as raw HTML with {{placeholders}}.
     * See App\Services\TemplateRenderer for the supported placeholder syntax.
     */
    public function storeCustom(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'html' => ['required', 'string', 'max:50000'],
        ]);

        $template = ResumeTemplate::create([
            'name' => $data['name'],
            'html' => $data['html'],
            'created_by' => $request->user()->id,
            'is_default' => false,
        ]);

        return redirect('/templates')->with('status', "Template \"{$template->name}\" saved. You can pick it from any resume's editor.");
    }
}
