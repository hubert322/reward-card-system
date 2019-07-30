<?php

// if (preg_match ('/\/api\/reward-cards\/*/', $_SESSION["REQUEST_URI"]))
// {
//     header("Location: " . $_SERVER["DOCUMENT_ROOT"] . "/src/api/Router.php");
//     echo "HELLO";
// }
// else
// {
//     return false;
// }
header("Location: " . $_SERVER["DOCUMENT_ROOT"] . "/src/api/Router.php");
return false;