<?php

namespace App\Services;

use App\Models\Subject;
use App\Models\WeeklyPlan;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;

class WeeklyPlanService
{
    /**
     * Generate a .docx template with a 4-column table and 7 empty rows.
     */
    public function generateTemplate(): string
    {
        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection();
        $section->addText('Weekly Plan Template', ['bold' => true, 'size' => 16]);
        $section->addText('Fill in up to 7 subjects below. Do not modify the table structure.', ['size' => 10, 'italic' => true]);
        $section->addTextBreak();

        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ];
        $phpWord->addTableStyle('PlanTable', $tableStyle);

        $table = $section->addTable('PlanTable');

        // Header row
        $headerStyle = ['bold' => true, 'size' => 11];
        $headerCellStyle = ['bgColor' => 'D9E2F3', 'valign' => 'center'];

        $table->addRow();
        $table->addCell(600, $headerCellStyle)->addText('#', $headerStyle, ['alignment' => 'center']);
        $table->addCell(2500, $headerCellStyle)->addText('Title', $headerStyle);
        $table->addCell(5000, $headerCellStyle)->addText('Description', $headerStyle);
        $table->addCell(1800, $headerCellStyle)->addText('Date (YYYY-MM-DD)', $headerStyle);

        // 7 empty numbered rows
        for ($i = 1; $i <= 7; $i++) {
            $table->addRow(600);
            $table->addCell(600)->addText((string) $i, [], ['alignment' => 'center']);
            $table->addCell(2500)->addText('');
            $table->addCell(5000)->addText('');
            $table->addCell(1800)->addText('');
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'weekly_plan_') . '.docx';
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return $tempPath;
    }

    /**
     * Parse uploaded .docx file and extract subjects data from the first table.
     *
     * @return array Array of ['title' => ..., 'description' => ..., 'date' => ...]
     * @throws \Exception on validation errors
     */
    public function parseDocx(string $path): array
    {
        $phpWord = IOFactory::load($path);
        $table = null;

        // Find first table in the document
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof Table) {
                    $table = $element;
                    break 2;
                }
            }
        }

        if (!$table) {
            throw new \Exception('No table found in the uploaded document. Please use the provided template.');
        }

        $rows = $table->getRows();
        if (count($rows) < 2) {
            throw new \Exception('The table must have at least a header row and one data row.');
        }

        $subjects = [];

        // Skip header row (index 0)
        for ($i = 1; $i < count($rows); $i++) {
            $cells = $rows[$i]->getCells();

            if (count($cells) < 4) {
                continue;
            }

            $title = trim($this->extractCellText($cells[1]));
            $description = trim($this->extractCellText($cells[2]));
            $date = trim($this->extractCellText($cells[3]));

            // Skip empty rows
            if (empty($title) && empty($description) && empty($date)) {
                continue;
            }

            if (empty($title)) {
                throw new \Exception("Row {$i}: Title is required.");
            }

            if (empty($date)) {
                throw new \Exception("Row {$i}: Date is required.");
            }

            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                throw new \Exception("Row {$i}: Date must be in YYYY-MM-DD format. Got: '{$date}'");
            }

            // Convert description: bullet points to <ul><li>, plain lines to <br>
            $description = $this->convertDescriptionToHtml($description);

            $subjects[] = [
                'title' => $title,
                'description' => $description,
                'date' => $date,
            ];
        }

        if (empty($subjects)) {
            throw new \Exception('No valid subjects found in the document. Please fill in at least one row.');
        }

        return $subjects;
    }

    /**
     * Create Subject records from an approved WeeklyPlan.
     */
    public function createSubjectsFromPlan(WeeklyPlan $plan): void
    {
        foreach ($plan->parsed_data as $subjectData) {
            Subject::create([
                'session_id' => $plan->session_id,
                'title' => $subjectData['title'],
                'description' => $subjectData['description'],
                'date' => $subjectData['date'],
                'status' => 'approved',
            ]);
        }
    }

    /**
     * Extract plain text from a table cell.
     */
    private function extractCellText($cell): string
    {
        $text = '';
        foreach ($cell->getElements() as $element) {
            if ($element instanceof TextRun) {
                foreach ($element->getElements() as $child) {
                    if ($child instanceof Text) {
                        $text .= $child->getText();
                    }
                }
                $text .= "\n";
            } elseif ($element instanceof Text) {
                $text .= $element->getText() . "\n";
            }
        }
        return rtrim($text, "\n");
    }

    /**
     * Convert plain text description to HTML.
     * Lines starting with - or * become <ul><li>...</li></ul>
     * Other lines are joined with <br>.
     */
    private function convertDescriptionToHtml(string $text): string
    {
        if (empty($text)) {
            return '';
        }

        $lines = explode("\n", $text);
        $html = '';
        $inList = false;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            if (preg_match('/^[-*•]\s*(.+)$/', $line, $matches)) {
                if (!$inList) {
                    $html .= '<ul>';
                    $inList = true;
                }
                $html .= '<li>' . e($matches[1]) . '</li>';
            } else {
                if ($inList) {
                    $html .= '</ul>';
                    $inList = false;
                }
                $html .= e($line) . '<br>';
            }
        }

        if ($inList) {
            $html .= '</ul>';
        }

        // Remove trailing <br>
        $html = preg_replace('/<br>$/', '', $html);

        return $html;
    }
}
