
<?php

header('Content-Type: text/plain; charset=utf-8');

echo "=== VERCEL LARAVEL PATH DIAGNOSTIC ===\n\n";

echo "PHP VERSION: " . PHP_VERSION . "\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "GETCWD: " . getcwd() . "\n\n";

$paths = [
    'Project Root' => dirname(__DIR__),
    'Public Index' => dirname(__DIR__) . '/public/index.php',
    'Composer Autoload' => dirname(__DIR__) . '/vendor/autoload.php',
    'Bootstrap App' => dirname(__DIR__) . '/bootstrap/app.php',
    'Routes Web' => dirname(__DIR__) . '/routes/web.php',
    'Storage' => dirname(__DIR__) . '/storage',
];

foreach ($paths as $label => $path) {
    echo $label . ":\n";
    echo "PATH: " . $path . "\n";
    echo "EXISTS: " . (file_exists($path) ? 'YES' : 'NO') . "\n";
    echo "REALPATH: " . (realpath($path) ?: 'NOT FOUND') . "\n\n";
}
