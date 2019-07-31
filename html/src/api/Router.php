<?php

declare (strict_types=1);

namespace api;

class Router
{
    public function __construct ()
    {

    }

    public function request (string $url)
    {
        switch ($_SERVER["REQUEST_METHOD"])
        {
            case "GET":
                echo "Generate";
                break;
            case "PATCH":
                echo "Redeem";
                break;
            default:
                foreach ($_SERVER as $k => $v)
                {
                    echo "$k => $v";
                    echo "<br />";
                }
        }
    }
}

$router = new Router ();
$router->request ($_SERVER["REQUEST_URI"]);