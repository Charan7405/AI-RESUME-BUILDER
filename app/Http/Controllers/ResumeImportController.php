<?php

namespace App\Http\Controllers;

use App\Services\ResumeParserService;
use Illuminate\Http\Request;

class ResumeImportController extends Controller
{
    public function show()
    {
        return view('resumes.import');
    }

    public function handle(Request $request, ResumeParserService $parser)
    {
        $request->validate([
            'resume_file' => ['required', 'file', 'mimes:pdf,docx,doc,txt', 'max:10240'],
        ]);

        try {
            $parsed = $parser->parse($request->file('resume_file'));
        } catch (\Throwable $e) {
            return back()->withErrors(['resume_file' => $e->getMessage()]);
        }

        $resume = $request->user()->resumes()->create([
            'title' => $parsed['contact']['name'] ?? 'Imported Resume',
            'contact' => $parsed['contact'],
            'summary' => $parsed['summary'],
            'experience' => $parsed['experience'],
            'education' => $parsed['education'],
            'skills' => $parsed['skills'],
        ]);

        return redirect("/resumes/{$resume->id}/edit")
            ->with('status', 'Imported — check over the details below and edit anything that needs fixing.');
    }
}
