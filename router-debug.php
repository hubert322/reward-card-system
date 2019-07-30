<?php


if (strpos ($_SERVER['REQUEST_URI'], "api/reward-cards"))
{
    require $_SERVER["DOCUMENT_ROOT"] . "/src/api/Router.php";
}
else
{
    return false;
}