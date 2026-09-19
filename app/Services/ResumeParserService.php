<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use RuntimeException;
use Smalot\PdfParser\Parser as PdfParser;

class ResumeParserService
{
    public function __construct(private GeminiService $gemini)
    {
    }

    /**
     * Returns an array matching the Resume model's fields:
     * contact, summary, experience[], education[], skills[]
     */
    public function parse(UploadedFile $file): array
    {
        $text = $this->extractText($file);

        if (trim($text) === '') {
            throw new RuntimeException('Could not read any text from that file. Try a text-based PDF or DOCX (not a scanned image).');
        }

        $schema = <<<'SCHEMA'
        {
          "contact": {"name": "", "title": "", "email": "", "phone": "", "location": "", "links": ""},
          "summary": "",
          "experience": [{"role": "", "company": "", "period": "", "bullets": ""}],
          "education": [{"school": "", "degree": "", "period": ""}],
          "skills": ["skill1", "skill2"]
        }
        SCHEMA;

        $prompt = "Extract structured resume data from the text below and return ONLY valid JSON matching this exact schema (no markdown fences, no explanation):\n\n{$schema}\n\nFor 'bullets', join each achievement with a newline character. If a field is missing, leave it an empty string or empty array.\n\nRESUME TEXT:\n\n{$text}";

        $data = $this->gemini->generateJson($prompt);

        return [
            'contact' => $data['contact'] ?? [],
            'summary' => $data['summary'] ?? '',
            'experience' => $data['experience'] ?? [],
            'education' => $data['education'] ?? [],
            'skills' => $data['skills'] ?? [],
        ];
    }

    private function extractText(UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());

        if ($ext === 'pdf') {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($file->getRealPath());
            return $pdf->getText();
        }

        if (in_array($ext, ['docx', 'doc'])) {
            $phpWord = WordIOFactory::load($file->getRealPath());
            $text = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    } elseif (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $sub) {
                            if (method_exists($sub, 'getText')) {
                                $text .= $sub->getText() . "\n";
                            }
                        }
                    }
                }
            }
            return $text;
        }

        if ($ext === 'txt') {
            return file_get_contents($file->getRealPath());
        }

        throw new RuntimeException("Unsupported file type: .{$ext}. Upload a PDF, DOCX, or TXT.");
    }
}
