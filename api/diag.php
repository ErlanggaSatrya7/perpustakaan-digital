<?php

ob_start();

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
$app = require $root . '/bootstrap/app.php';
ob_clean();

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

echo "<pre>";
echo "=== VITE ASSET DIAGNOSTIC ===\n\n";

// 1. Check public path
$publicPath = public_path();
echo "public_path(): $publicPath\n";
echo "public_path exists: " . (is_dir($publicPath) ? 'YES' : 'NO') . "\n\n";

// 2. Check manifest
$manifest = $publicPath . '/build/manifest.json';
echo "Manifest path: $manifest\n";
echo "Manifest exists: " . (file_exists($manifest) ? 'YES' : 'NO') . "\n";
if (file_exists($manifest)) {
    echo "Manifest content:\n" . file_get_contents($manifest) . "\n";
}

// 3. Check CSS/JS files
$css = $publicPath . '/build/assets/app-2-1MBrgv.css';
$js = $publicPath . '/build/assets/app-BPrTyeqd.js';
echo "CSS file exists: " . (file_exists($css) ? 'YES' : 'NO') . "\n";
echo "JS file exists: " . (file_exists($js) ? 'YES' : 'NO') . "\n";
echo "CSS size: " . (file_exists($css) ? filesize($css) . " bytes" : 'N/A') . "\n\n";

// 4. Check what @vite() would generate
echo "=== VITE TAG OUTPUT ===\n";
try {
    $viteHtml = app(\Illuminate\Foundation\Vite::class)(['resources/css/app.css', 'resources/js/app.js']);
    echo htmlspecialchars((string) $viteHtml) . "\n";
} catch (\Throwable $e) {
    echo "VITE ERROR: " . $e->getMessage() . "\n";
}

// 5. Check APP_URL
echo "\n=== ENV VALUES ===\n";
echo "APP_URL: " . config('app.url') . "\n";
echo "APP_ENV: " . config('app.env') . "\n";
echo "ASSET_URL: " . config('app.asset_url', '(not set)') . "\n";
echo "</pre>";
