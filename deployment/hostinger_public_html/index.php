<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// The Laravel application is stored in public_html/luxury.
if (file_exists($maintenance = __DIR__.'/luxury/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/luxury/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/luxury/bootstrap/app.php';

// Public assets and uploaded project media are stored directly in public_html.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
