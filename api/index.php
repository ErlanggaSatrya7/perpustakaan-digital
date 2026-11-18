
<?php

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';

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

$request = Illuminate\Http\Request::capture();

error_log('DIAG URI: ' . $request->getRequestUri());
error_log('DIAG PATH: ' . $request->path());

$kernel = $app->make(
    Illuminate\Contracts\Http\Kernel::class
);

$response = $kernel->handle($request);

error_log('DIAG STATUS: ' . $response->getStatusCode());
error_log('DIAG BODY LENGTH: ' . strlen($response->getContent()));
error_log('DIAG CONTENT TYPE: ' . $response->headers->get('Content-Type'));

$response->send();

$kernel->terminate($request, $response);
