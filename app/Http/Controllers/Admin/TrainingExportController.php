<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\TrainingExport;
use App\Services\TrainingScrubberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TrainingExportController extends Controller
{
    public function index()
    {
        $exports = TrainingExport::latest()->paginate(25);

        // Resumes that opted in but have no export row yet
        $pendingCount = Resume::where('consent_training', true)
            ->whereNotIn('id', TrainingExport::pluck('resume_id'))
            ->count();

        return view('admin.training', compact('exports', 'pendingCount'));
    }

    /**
     * Scrub every opted-in resume that doesn't have an export yet.
     */
    public function runBatch(TrainingScrubberService $scrubber)
    {
        $resumes = Resume::where('consent_training', true)
            ->whereNotIn('id', TrainingExport::pluck('resume_id'))
            ->get();

        $created = 0;
        foreach ($resumes as $resume) {
            if ($scrubber->export($resume)) {
                $created++;
            }
        }

        return redirect('/admin/training')->with('status', "Created {$created} new training export(s).");
    }

    /**
     * Download everything as JSONL — the format most training pipelines
     * (including ACCR AI OS's Dataset module) can ingest directly.
     */
    public function downloadJsonl()
    {
        $lines = TrainingExport::all()->map(function ($export) {
            return json_encode(['text' => $export->scrubbed_text], JSON_UNESCAPED_SLASHES);
        })->implode("\n");

        return Response::make($lines, 200, [
            'Content-Type' => 'application/jsonl',
            'Content-Disposition' => 'attachment; filename="resume-training-export.jsonl"',
        ]);
    }
}
