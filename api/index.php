<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

try {
    require $root . '/vendor/autoload.php';
} catch (\Throwable $e) {
    die('<pre>AUTOLOAD ERROR: ' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>');
}

try {
    $app = require $root . '/bootstrap/app.php';
} catch (\Throwable $e) {
    die('<pre>BOOTSTRAP ERROR: ' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>');
}

$storage = '/tmp/laravel-storage';

foreach ([
    $storage . '/framework/cache/data',
    $storage . '/framework/sessions',
    $storage . '/framework/views',
    $storage . '/logs',
] as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

$app->useStoragePath($storage);

try {
    $request = Illuminate\Http\Request::capture();
    $app->handleRequest($request);
} catch (\Throwable $e) {
    die('<pre>LARAVEL HANDLE ERROR: ' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>');
}
