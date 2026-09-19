<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\TrainingExport;

class TrainingScrubberService
{
    /**
     * Keeps ONLY: summary text, experience role titles + bullet sentences, education degree titles.
     * Drops: name, email, phone, location, links, company names, school names —
     * anything that could identify the person.
     */
    public function scrub(Resume $resume): string
    {
        $lines = [];

        if ($resume->summary) {
            $lines[] = trim($resume->summary);
        }

        foreach ($resume->experience ?? [] as $exp) {
            if (! empty($exp['role'])) {
                $lines[] = trim($exp['role']); // job title/role wording, not company
            }
            foreach (explode("\n", $exp['bullets'] ?? '') as $bullet) {
                $bullet = trim($bullet);
                if ($bullet !== '') {
                    $lines[] = $bullet;
                }
            }
        }

        foreach ($resume->education ?? [] as $edu) {
            if (! empty($edu['degree'])) {
                $lines[] = trim($edu['degree']); // degree wording, not school name
            }
        }

        return implode("\n", array_filter($lines));
    }

    /**
     * Scrubs and saves a training_exports row. Only runs if the user opted in
     * (Resume.consent_training) — respects the T&C.
     */
    public function export(Resume $resume): ?TrainingExport
    {
        if (! $resume->consent_training) {
            return null;
        }

        $text = $this->scrub($resume);

        if (trim($text) === '') {
            return null;
        }

        return TrainingExport::create([
            'resume_id' => $resume->id,
            'scrubbed_text' => $text,
        ]);
    }
}
