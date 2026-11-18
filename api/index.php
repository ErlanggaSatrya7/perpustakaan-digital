<?php

header('Content-Type: text/plain; charset=utf-8');

echo "STEP 1: API ENTRYPOINT START\n";
flush();

require __DIR__ . '/../public/index.php';

echo "\nSTEP 2: PUBLIC INDEX FINISHED\n";
