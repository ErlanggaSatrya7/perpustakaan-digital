<?php

error_reporting(E_ALL);
ini_set("display_errors", "1");

header("Content-Type: text/plain; charset=utf-8");

echo "STEP 1: PHP RUNTIME OK\n";

try {
    $root = dirname(__DIR__);

    require $root . "/vendor/autoload.php";
    echo "STEP 2: COMPOSER AUTOLOAD OK\n";

    $app = require $root . "/bootstrap/app.php";
    echo "STEP 3: LARAVEL BOOTSTRAP OK\n";

    echo "STEP 4: LARAVEL VERSION " . $app->version() . "\n";
} catch (Throwable $e) {
    echo "\nBOOTSTRAP ERROR\n";
    echo "TYPE: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
