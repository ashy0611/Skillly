<?php

namespace App\Services\Resume;

use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class ResumeParserService
{
    public function extractText(string $filePath, string $extension): string
    {
        $extension = strtolower($extension);

        if ($extension === 'pdf') {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($filePath);
                return $pdf->getText() ?? '';
            } catch (\Throwable $e) {
                throw new \RuntimeException('Failed to parse PDF. The file may be corrupted or password-protected.', 0, $e);
            }
        }

        if (in_array($extension, ['doc', 'docx'])) {
            try {
                $phpWord = IOFactory::load($filePath);
                $text = '';

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                            $text .= $element->getText() . ' ';
                        }
                        if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                            foreach ($element->getElements() as $textElement) {
                                if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                    $text .= $textElement->getText() . ' ';
                                }
                            }
                        }
                    }
                }
                return $text;
            } catch (\Throwable $e) {
                throw new \RuntimeException('Failed to parse Word document. The file may be corrupted or in an unsupported format.', 0, $e);
            }
        }

        throw new \InvalidArgumentException('Unsupported file type. Use PDF, DOC, or DOCX.');
    }
}
