
<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->handleRequest(
        Illuminate\Http\Request::capture()
    );

} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');

    echo "LARAVEL REQUEST ERROR\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
