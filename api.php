<?php

session_start ();

require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/vendor/autoload.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/dataAccess/DataManager.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/util/SQLUtil.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/dataAccess/RewardCardDbGateway.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/util/LazHtmlToPdf.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/PdfService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/QrCodeService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/RewardCardService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/SessionInfoCacheService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/api/RewardCardApiController.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/api/RewardCardRouter.class.php";

use api\RewardCardRouter;
use Exception;

// Setup Environment variables
$file = @fopen ("./env.conf", "r");
if ($file)
{
    while (!feof ($file))
    {
        $line = fgets ($file);
        if ($line)
        {
            [0 => $key, 1 => $value] = explode (": ", $line);
            $_ENV[$key] = str_replace ([" ", "\n", "\r"], "", $value);
        }
    }
    fclose ($file);
}

try
{
    $router = new RewardCardRouter ();
    $router->request ($_SERVER["REQUEST_METHOD"]);
}
catch (Exception $e)
{
    echo "Caught exception: " . $e->getMessage () . "\n";
}