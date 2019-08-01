<?php
declare (strict_types=1);

namespace services;

use util\LazHtmlToPdf;

class PdfService
{
    public function __construct(?int $shardConfigurationId)
    {

    }

    public function getHtml (string $pdfTemplateFilePath, array $qrCodeSources): string
    {
        ob_start();
        include ($pdfTemplateFilePath);
        $rawHtml = ob_get_contents ();
        ob_end_clean ();
        return $rawHtml;
    }

    public function generatePdf (string $html, string $filename)
    {
        ob_start();
        $pdf = new LazHtmlToPdf ();
        $pdfOutput = $pdf->getOutputFromHtml ($html);
        $pdf->sendHttp ($pdfOutput, $filename, false, true);
    }
}