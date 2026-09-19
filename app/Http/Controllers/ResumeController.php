<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\ResumeTemplate;
use App\Services\GeminiService;
use App\Services\TemplateRenderer;
use App\Services\TrainingScrubberService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        $resumes = $request->user()->resumes()->latest()->get();
        return view('resumes.index', compact('resumes'));
    }

    public function create(Request $request)
    {
        $resume = $request->user()->resumes()->create([
            'title' => 'My Resume',
            'contact' => ['name' => $request->user()->name, 'title' => '', 'email' => $request->user()->email, 'phone' => '', 'location' => '', 'links' => ''],
            'summary' => '',
            'experience' => [],
            'education' => [],
            'skills' => [],
        ]);

        return redirect("/resumes/{$resume->id}/edit");
    }

    public function edit(Request $request, Resume $resume)
    {
        $this->authorizeOwner($request, $resume);
        $templates = ResumeTemplate::query()->where('is_default', true)
            ->orWhere('created_by', $request->user()->id)
            ->get();

        return view('resumes.edit', compact('resume', 'templates'));
    }

    public function update(Request $request, Resume $resume)
    {
        $this->authorizeOwner($request, $resume);

        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'array'],
            'summary' => ['nullable', 'string'],
            'experience' => ['nullable', 'array'],
            'education' => ['nullable', 'array'],
            'skills' => ['nullable', 'array'],
            'template_id' => ['nullable', 'exists:resume_templates,id'],
            'consent_training' => ['nullable', 'boolean'],
        ]);

        $resume->update($data);

        return response()->json(['ok' => true]);
    }

    public function destroy(Request $request, Resume $resume)
    {
        $this->authorizeOwner($request, $resume);
        $resume->delete();
        return redirect('/resumes');
    }

    /**
     * AI text enhance endpoint used by the editor's "Enhance with AI" buttons.
     * Body: { "prompt": "..." }
     */
    public function enhance(Request $request, GeminiService $gemini)
    {
        $request->validate(['prompt' => ['required', 'string', 'max:6000']]);

        try {
            $text = $gemini->generate($request->input('prompt'));
            return response()->json(['text' => $text]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 502);
        }
    }

    public function exportPdf(Request $request, Resume $resume, TemplateRenderer $renderer, TrainingScrubberService $scrubber)
    {
        $this->authorizeOwner($request, $resume);

        $template = $resume->template ?? ResumeTemplate::where('is_default', true)->first();
        $html = $renderer->render($template->html, $resume);

        // Feed the anonymized training pipeline whenever a resume is finalized/exported.
        $scrubber->export($resume);

        $pdf = Pdf::loadHTML($html);
        return $pdf->download(($resume->title ?: 'resume') . '.pdf');
    }

    private function authorizeOwner(Request $request, Resume $resume): void
    {
        abort_unless($resume->user_id === $request->user()->id, 403);
    }
}
