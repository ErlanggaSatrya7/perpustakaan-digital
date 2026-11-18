
<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

register_shutdown_function(function () {
    $error = error_get_last();

    echo "\nSHUTDOWN HANDLER REACHED\n";

    if ($error !== null) {
        echo "ERROR TYPE: " . $error['type'] . "\n";
        echo "ERROR MESSAGE: " . $error['message'] . "\n";
        echo "ERROR FILE: " . $error['file'] . "\n";
        echo "ERROR LINE: " . $error['line'] . "\n";
    } else {
        echo "NO PHP FATAL ERROR DETECTED\n";
    }
});

echo "STEP 1: API ENTRYPOINT START\n";

require __DIR__ . '/../public/index.php';

echo "\nSTEP 2: PUBLIC INDEX FINISHED\n";
