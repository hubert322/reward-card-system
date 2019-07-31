<?php

require_once "./src/dataAccess/DataManager.class.php";
require_once "./src/dataAccess/RewardCardDbGateway.class.php";
require_once "./src/services/QrCodeService.class.php";
require_once "./src/services/RewardCardService.class.php";
require_once "./src/services/SessionInfoCacheService.class.php";
require_once "./src/api/RewardCardApiController.class.php";
require_once "./src/api/RewardCardRouter.class.php";

use api\RewardCardRouter;

session_start ();

$router = new RewardCardRouter ();
$router->request ($_SERVER["REQUEST_METHOD"]);
