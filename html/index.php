<?php

// Setup Environment variables
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

session_start ();

require_once "./index.html";


