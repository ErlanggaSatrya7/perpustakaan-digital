<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Setup folder-folder sementara di /tmp agar view, cache, session, dan log bisa ditulis
$tmpDirs = [
    '/tmp/framework/views',
    '/tmp/framework/sessions',
    '/tmp/framework/cache',
    '/tmp/logs',
];
foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Laravel application root
$basePath = dirname(__DIR__);

// Register the Composer autoloader...
require $basePath.'/vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once $basePath.'/bootstrap/app.php';

// Paksa Laravel menggunakan /tmp untuk seluruh storage
$app->useStoragePath('/tmp');

// Jalankan request
$app->handleRequest(Request::capture());
