<?php
declare (strict_types=1);

namespace services;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use LAZ\objects\library\LazHtmlToPdf;

class QrCodeService
{
    private $logoPath;

    public function __construct()
    {
        $this->logoPath = $_ENV["ROOT_WWW_PATH"] . '/html/kidsa-z/images/mobile/ios/appIcon/Icon-72@2x.png';
    }

    public function generateQrCode (string $inputCode): string
    {
        $qrCode = new QrCode ($inputCode);
        $qrCode->setSize(300);

        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
        $qrCode->setLogoPath($this->logoPath);
        $qrCode->setLogoSize(100, 100);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);

        //return $qrCode;
        return $this->generateQrCodeImage($qrCode);
    }

    public function setQrCodeBackgroundColor (QrCode $qrCode, array $color): void
    {
        $qrCode->setBackgroundColor ($color);
    }

    public function setQrCodeForegroundColor (QrCode $qrCode, array $color): void
    {
        $qrCode->setForegroundColor ($color);
    }

    public function generateQrCodeImage (QrCode $qrCode): string
    {
        return base64_encode ($qrCode->writeString ());
    }
}