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

// Force HTTPS — Vercel proxy internal pakai HTTP
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = 443;

// Fix: Laravel jalan dari api/index.php, tapi harus pura-pura dari /index.php
// supaya url() helper tidak strip /api/ prefix dari URL
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/public/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

$app->handleRequest(Illuminate\Http\Request::capture());
