<?php

session_start ();

require_once $_SERVER["DOCUMENT_ROOT"] . "/src/dataAccess/DataManager.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/dataAccess/RewardCardDbGateway.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/QrCodeService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/RewardCardService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/services/SessionInfoCacheService.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/api/RewardCardApiController.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/api/RewardCardRouter.class.php";

use api\RewardCardRouter;

$router = new RewardCardRouter ();
$router->request ($_SERVER["REQUEST_METHOD"]);