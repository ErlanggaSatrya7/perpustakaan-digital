<?php

// Quick diagnostic - runs before Laravel
echo "<pre>";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Extensions loaded:\n";
$exts = get_loaded_extensions();
sort($exts);
foreach ($exts as $ext) {
    echo "  - $ext\n";
}
echo "\nConstants:\n";
echo "  __DIR__: " . __DIR__ . "\n";
echo "  dirname(__DIR__): " . dirname(__DIR__) . "\n";
echo "  vendor/autoload exists: " . (file_exists(dirname(__DIR__) . '/vendor/autoload.php') ? 'YES' : 'NO') . "\n";
echo "  bootstrap/app exists: " . (file_exists(dirname(__DIR__) . '/bootstrap/app.php') ? 'YES' : 'NO') . "\n";
echo "</pre>";
