
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$root = dirname(__DIR__);

ob_start();

try {
    require $root . '/vendor/autoload.php';

    $app = require $root . '/bootstrap/app.php';

    $kernel = $app->make(
        Illuminate\Contracts\Http\Kernel::class
    );

    $request = Illuminate\Http\Request::capture();

    $response = $kernel->handle($request);

    $status = $response->getStatusCode();
    $body = $response->getContent();

    $kernel->terminate($request, $response);

    ob_end_clean();

    header('Content-Type: text/plain; charset=utf-8');

    echo "ENTRYPOINT DIAGNOSTIC\n";
    echo "REQUEST URI: " . $request->getRequestUri() . "\n";
    echo "STATUS: " . $status . "\n";
    echo "BODY LENGTH: " . strlen($body) . "\n";
    echo "BODY PREVIEW:\n";
    echo substr(strip_tags($body), 0, 500);

} catch (Throwable $e) {
    ob_end_clean();

    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');

    echo "ERROR: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
