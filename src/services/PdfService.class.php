<?php

namespace services;

use util\LazHtmlToPdf;

class PdfService
{
    public function __construct(?int $shardConfigurationid)
    {

    }

    public function getHtml (string $pdfTemplateFilePath, array $qrCodeSources)
    {
        ob_start();
        include ($pdfTemplateFilePath);
        return ob_get_clean();
    }

    public function generatePdf (string $html, string $filename)
    {
        $pdf = new LazHtmlToPdf ($this->logger);
        $pdfOutput = $pdf->getOutputFromHtml ($html);
        $pdf->sendHttp ($pdfOutput, $filename, false, true);
    }
}