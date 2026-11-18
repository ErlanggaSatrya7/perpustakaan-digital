<?php

// Buffer semua output agar tidak ada yang "bocor" sebelum Laravel kirim headers
ob_start();

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';

// Bersihkan output apapun yang mungkin keluar saat bootstrap (BOM, whitespace, dll)
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

$app->handleRequest(Illuminate\Http\Request::capture());
