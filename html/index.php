<?php

$file = @fopen ("./env.conf", "r");
if ($file)
{
    while (!feof ($file))
    {
        $line = fgets ($file);
        if ($line)
        {
            [0 => $key, 1 => $value] = explode (": ", $line);
            $_ENV[$key] = $value;
        }
    }
    fclose ($file);
}

require_once "./src/dataAccess/DataManager.class.php";
require_once "./src/dataAccess/RewardCardDbGateway.class.php";
require_once "./src/services/QrCodeService.class.php";
require_once "./src/services/RewardCardService.class.php";
require_once "./src/services/SessionInfoCacheService.class.php";
require_once "./src/api/RewardCardApiController.class.php";
require_once "./index.html";
