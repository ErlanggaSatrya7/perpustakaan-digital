
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: text/plain; charset=utf-8');

$root = dirname(__DIR__);

try {
    require $root . '/vendor/autoload.php';

    $app = require $root . '/bootstrap/app.php';

    $kernel = $app->make(
        Illuminate\Contracts\Http\Kernel::class
    );

    echo "LARAVEL HTTP REQUEST TEST\n";
    echo "=========================\n";

    foreach (['/up', '/login'] as $path) {
        echo "\nTEST ROUTE: {$path}\n";

        try {
            $request = Illuminate\Http\Request::create(
                $path,
                'GET',
                [],
                [],
                [],
                [
                    'HTTP_HOST' => 'perpustakaan-digital-seven-ivory.vercel.app',
                    'HTTPS' => 'on',
                ]
            );

            $response = $kernel->handle($request);

            echo "STATUS: " . $response->getStatusCode() . "\n";

            $content = $response->getContent();

            echo "CONTENT LENGTH: " . strlen($content) . "\n";
            echo "CONTENT PREVIEW:\n";
            echo substr(strip_tags($content), 0, 300) . "\n";

            $kernel->terminate($request, $response);

        } catch (Throwable $e) {
            echo "ROUTE ERROR: " . get_class($e) . "\n";
            echo "MESSAGE: " . $e->getMessage() . "\n";
            echo "FILE: " . $e->getFile() . "\n";
            echo "LINE: " . $e->getLine() . "\n";
        }
    }

} catch (Throwable $e) {
    echo "BOOTSTRAP ERROR: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
