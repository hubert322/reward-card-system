<?php

$file = fopen ("./env.conf", "r");
while (!feof ($file))
{
    $line = fgets ($file);
    if ($line !== "\n")
    {
        [0 => $key, 1 => $value] = explode (": ", $line);
        $_ENV[$key] = $value;
    }
}

foreach ($_ENV as $k => $v)
{
    echo $k . " => " . $v;
    echo "<br />";
}

require_once "./index.html";
