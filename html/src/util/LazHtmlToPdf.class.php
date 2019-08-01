<?php

namespace util;

use Knp\Snappy\Pdf;
use Psr\Log\LoggerInterface;

//require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/vendor/knplabs/knp-snappy/src/Knp/Snappy/GeneratorInterface.php";
//require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/vendor/knplabs/knp-snappy/src/Knp/Snappy/AbstractGenerator.php";
//require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/vendor/knplabs/knp-snappy/src/Knp/Snappy/Pdf.php";

class LazHtmlToPdf extends Pdf {

    public function __construct(LoggerInterface $logger=null, array $options = []) {
        parent::__construct(dirname($_SERVER["DOCUMENT_ROOT"]) . "/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64", $options);
        //$this->setTemporaryFolder($_ENV['temp_file_location']);
        if($logger) {
            $this->setLogger($logger);
        }
    }

    public function sendHttp($content, $filename = null, $inline = false, $isApiCall = false) {
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/pdf');
        header('Content-Transfer-Encoding: binary');

        if ($filename !== null || $inline) {
            $disposition = $inline ? 'inline' : 'attachment';
            header("Content-Disposition: $disposition; filename=\"$filename\"");
        }

        echo $content;

        if ($isApiCall) {
            exit ();
        }
    }

//    public function createTemporaryPdf() {
//        return $this->createTemporaryFile(null, "pdf");
//    }
}