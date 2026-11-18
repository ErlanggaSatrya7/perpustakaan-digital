<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';

$storage = '/tmp/laravel-storage';

$directories = [
    $storage . '/framework/cache/data',
    $storage . '/framework/sessions',
    $storage . '/framework/views',
    $storage . '/logs',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

$app->useStoragePath($storage);

$app->handleRequest(Request::capture());
