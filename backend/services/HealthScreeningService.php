<?php
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

class HealthScreeningService {
    private $db;
    private $cacheDir;

    public function __construct($db) {
        $this->db = $db;
        $this->cacheDir = __DIR__ . '/../cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    // ... (keep existing methods)

    public function generatePDF($reportData) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $reportData['report_type'], 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        foreach ($reportData as $key => $value) {
            if ($key !== 'report_type') {
                if (is_array($value)) {
                    $pdf->Cell(0, 10, ucfirst($key) . ':', 0, 1);
                    foreach ($value as $subKey => $subValue) {
                        $pdf->Cell(0, 10, "  " . ucfirst($subKey) . ': ' . $subValue, 0, 1);
                    }
                } else {
                    $pdf->Cell(0, 10, ucfirst($key) . ': ' . $value, 0, 1);
                }
            }
        }

        return $pdf->Output('S');
    }

    public function generatePatientSummaryReport($dateRange) {
        $cacheKey = "patient_summary_" . $dateRange['start'] . "_" . $dateRange['end'];
        $cachedReport = $this->getCachedReport($cacheKey);
        if ($cachedReport) {
            return $this->generatePDF($cachedReport);
        }

        // ... (keep existing query logic)

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->setCachedReport($cacheKey, $result);
        return $this->generatePDF($result);
    }

    // ... (update other report generation methods similarly)

    public function generateCustomReport($dateRange, $customReportOptions) {
        $cacheKey = "custom_report_" . $dateRange['start'] . "_" . $dateRange['end'] . "_" . 
                    $customReportOptions['disease'] . "_" . $customReportOptions['demographic'] . "_" . 
                    ($customReportOptions['ageGroup'] ?? '') . "_" .
                    implode(',', $customReportOptions['screeningTypes']) . "_" .
                    ($customReportOptions['location'] ?? '');
        $cachedReport = $this->getCachedReport($cacheKey);
        if ($cachedReport) {
            return $this->generatePDF($cachedReport);
        }

        // ... (keep existing logic for generating custom report data)

        $result = [
            'report_type' => 'Custom Report',
            'date_range' => $dateRange,
            'disease' => $disease,
            'demographic' => $demographic,
            'age_group' => $ageGroup,
            'screening_types' => implode(', ', $customReportOptions['screeningTypes']),
            'location' => $customReportOptions['location'] ?: 'All Locations',
            'total_patients' => $totalPatients,
            'affected_patients' => $affectedPatients,
            'percentage' => round($percentage, 2)
        ];

        $this->setCachedReport($cacheKey, $result);
        return $this->generatePDF($result);
    }

    // ... (keep other methods)
}
