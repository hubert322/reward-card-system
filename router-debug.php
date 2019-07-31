<?php


if (strpos ($_SERVER['REQUEST_URI'], "api/reward-cards"))
{
    require $_SERVER["DOCUMENT_ROOT"] . "/api.php";
}
else
{
    return false;
}