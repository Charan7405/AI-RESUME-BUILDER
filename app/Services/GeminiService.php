<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    public function generate(string $prompt): string
    {
        $apiKey = AppSetting::get('gemini_api_key');

        if (! $apiKey) {
            throw new RuntimeException('No Gemini API key configured. Ask an admin to add one in /admin/settings.');
        }

        $response = Http::timeout(30)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key={$apiKey}",
            [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
            ]
        );

        if (! $response->successful()) {
            throw new RuntimeException('Gemini request failed: ' . $response->body());
        }

        return trim(
            $response->json('candidates.0.content.parts.0.text') ?? ''
        );
    }

    /**
     * Ask Gemini to return strict JSON and decode it.
     * Strips ```json fences if the model adds them.
     */
    public function generateJson(string $prompt): array
    {
        $raw = $this->generate($prompt);
        $clean = trim(preg_replace('/^```json|```$/m', '', $raw));
        $decoded = json_decode($clean, true);

        return is_array($decoded) ? $decoded : [];
    }
}
