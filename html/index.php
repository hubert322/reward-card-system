<?php

$file = fopen ("./env.conf", "r");
while (!feof ($file))
{
    [0 => $key, 1 => $value] = explode (": ", fgets ($file));
    $_ENV[$key] = $value;
}

foreach ($_ENV as $k => $v)
{
    echo $k . " => " . $v;
    echo "<br />";
}

require_once "./index.html";
