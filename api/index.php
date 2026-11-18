
<?php

header('Content-Type: text/plain; charset=utf-8');

echo "STEP 1: PHP FUNCTION OK\n";

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "STEP 2: COMPOSER AUTOLOAD OK\n";

    $app = require __DIR__ . '/../bootstrap/app.php';
    echo "STEP 3: LARAVEL BOOTSTRAP OK\n";

    echo "STEP 4: LARAVEL VERSION " . $app->version() . "\n";

} catch (\Throwable $e) {
    echo "\nERROR: " . get_class($e) . "\n";
    echo "MESSAGE: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . "\n";
    echo "LINE: " . $e->getLine() . "\n";
}
