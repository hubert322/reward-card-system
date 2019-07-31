<?php


if (strpos ($_SERVER['REQUEST_URI'], "api/reward-cards"))
{
    require $_SERVER["DOCUMENT_ROOT"] . "/src/api/RewardCardRouter.class.php";
}
else
{
    return false;
}