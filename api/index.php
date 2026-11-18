<?php

ob_start();

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';

ob_clean();

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

// Force HTTPS — Vercel proxy internal pakai HTTP, tapi user akses via HTTPS
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = 443;

$app->handleRequest(Illuminate\Http\Request::capture());
