<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');

$publicRoot = __DIR__;
$laravelRoot = __DIR__.'/luxury';

function checkItem(string $label, bool $passed, string $detail = ''): void
{
    echo ($passed ? '[OK]   ' : '[FAIL] ').$label;
    if ($detail !== '') {
        echo ': '.$detail;
    }
    echo PHP_EOL;
}

echo "Luxury Homes Hostinger diagnostic\n";
echo "=================================\n";
checkItem('PHP version is 8.3 or newer', version_compare(PHP_VERSION, '8.3.0', '>='), PHP_VERSION);
checkItem('Laravel folder', is_dir($laravelRoot), $laravelRoot);
checkItem('Composer autoloader', is_file($laravelRoot.'/vendor/autoload.php'));
checkItem('Laravel bootstrap file', is_file($laravelRoot.'/bootstrap/app.php'));
checkItem('Environment file', is_file($laravelRoot.'/.env'));
checkItem('Storage directory is writable', is_writable($laravelRoot.'/storage'));
checkItem('Bootstrap cache is writable', is_writable($laravelRoot.'/bootstrap/cache'));
checkItem('Vite manifest', is_file($publicRoot.'/build/manifest.json'));
checkItem('ProjectMedia model file', is_file($laravelRoot.'/app/Models/ProjectMedia.php'));

echo "\nBootstrap checks\n";
echo "----------------\n";

try {
    require $laravelRoot.'/vendor/autoload.php';

    /** @var \Illuminate\Foundation\Application $app */
    $app = require $laravelRoot.'/bootstrap/app.php';
    $app->usePublicPath($publicRoot);
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    checkItem('Laravel booted', true, $app->version());
    checkItem('APP_KEY is configured', filled(config('app.key')));
    checkItem('ProjectMedia class loads', class_exists(\App\Models\ProjectMedia::class));

    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        checkItem('Database connection', true, (string) config('database.default'));
        checkItem('projects table exists', \Illuminate\Support\Facades\Schema::hasTable('projects'));
        checkItem('project_media table exists', \Illuminate\Support\Facades\Schema::hasTable('project_media'));
    } catch (Throwable $databaseError) {
        checkItem('Database connection', false, $databaseError->getMessage());
    }
} catch (Throwable $error) {
    checkItem('Laravel booted', false);
    echo "\nERROR TYPE: ".get_class($error).PHP_EOL;
    echo 'MESSAGE: '.$error->getMessage().PHP_EOL;
    echo 'FILE: '.$error->getFile().':'.$error->getLine().PHP_EOL;
}

echo "\nDelete diagnose.php immediately after copying these results.\n";
