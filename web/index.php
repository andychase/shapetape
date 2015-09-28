<?php

preg_match("#^/([0-9]+)?/?$#", $_SERVER['REQUEST_URI'], $matches);

if ($_SERVER['REQUEST_URI'] == "/" || $_SERVER['REQUEST_URI'] == ""  ||
    $_SERVER['REQUEST_URI'] == "/view" || count($matches) > 0) {
    if (count($matches) > 1) {
        $_GET['v'] = $matches[1];
        require("viewer.php");
    } else {
        require("upload.html");
    }

    return true;
}

$development = strstr($_SERVER['SERVER_SOFTWARE'], " Development Server") != false;

if ($development)
    return false;
else
    require("404.html");
