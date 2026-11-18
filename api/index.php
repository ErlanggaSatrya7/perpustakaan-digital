
<?php

ob_start();

try {
    require __DIR__ . '/../public/index.php';

    $body = ob_get_clean();

    header('Content-Type: text/plain; charset=utf-8');

    echo "ENTRYPOINT: OK\n";
    echo "BODY_LENGTH: " . strlen($body) . "\n";
    echo "BODY_HEX: " . bin2hex(substr($body, 0, 200)) . "\n";
    echo "BODY_PREVIEW:\n";
    echo substr($body, 0, 500);

} catch (\Throwable $e) {
    if (ob_get_level() > 0) {
        ob_end_clean();
    }

    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');

    echo "ERROR: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
