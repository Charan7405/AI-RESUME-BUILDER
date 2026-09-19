<?php

namespace App\Services;

use App\Models\Resume;

class TemplateRenderer
{
    /**
     * Template syntax (simple, mustache-style):
     *   {{name}} {{title}} {{email}} {{phone}} {{location}} {{links}} {{summary}} {{skills}}
     *   {{#experience}} ... {{role}} {{company}} {{period}} {{bullets_html}} ... {{/experience}}
     *   {{#education}} ... {{school}} {{degree}} {{period}} ... {{/education}}
     */
    public function render(string $templateHtml, Resume $resume): string
    {
        $contact = $resume->contact ?? [];
        $html = $templateHtml;

        $scalars = [
            'name' => $contact['name'] ?? '',
            'title' => $contact['title'] ?? '',
            'email' => $contact['email'] ?? '',
            'phone' => $contact['phone'] ?? '',
            'location' => $contact['location'] ?? '',
            'links' => $contact['links'] ?? '',
            'summary' => nl2br(e($resume->summary ?? '')),
            'skills' => e(implode(', ', $resume->skills ?? [])),
        ];

        foreach ($scalars as $key => $value) {
            $html = str_replace('{{' . $key . '}}', $value, $html);
        }

        $html = $this->renderLoop($html, 'experience', $resume->experience ?? [], function ($item) {
            $bullets = collect(explode("\n", $item['bullets'] ?? ''))
                ->filter()
                ->map(fn ($b) => '<li>' . e($b) . '</li>')
                ->implode('');
            return [
                'role' => e($item['role'] ?? ''),
                'company' => e($item['company'] ?? ''),
                'period' => e($item['period'] ?? ''),
                'bullets_html' => '<ul>' . $bullets . '</ul>',
            ];
        });

        $html = $this->renderLoop($html, 'education', $resume->education ?? [], fn ($item) => [
            'school' => e($item['school'] ?? ''),
            'degree' => e($item['degree'] ?? ''),
            'period' => e($item['period'] ?? ''),
        ]);

        return $html;
    }

    private function renderLoop(string $html, string $tag, array $items, callable $mapFields): string
    {
        $pattern = '/\{\{#' . $tag . '\}\}(.*?)\{\{\/' . $tag . '\}\}/s';

        return preg_replace_callback($pattern, function ($m) use ($items, $mapFields) {
            $block = $m[1];
            $out = '';
            foreach ($items as $item) {
                $fields = $mapFields($item);
                $rendered = $block;
                foreach ($fields as $key => $value) {
                    $rendered = str_replace('{{' . $key . '}}', $value, $rendered);
                }
                $out .= $rendered;
            }
            return $out;
        }, $html);
    }
}
