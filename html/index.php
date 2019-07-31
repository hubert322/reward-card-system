<?php

$file = fopen ("./env.conf", "r");
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

require_once "./index.html";
