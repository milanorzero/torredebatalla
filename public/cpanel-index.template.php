<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// If you are deploying to cPanel with the Laravel app OUTSIDE public_html,
// update these paths to point to your real app folder.
//
// Example layout:
//   /staging.torredebatalla.cl/laravel-app/           (Laravel app root)
//   /staging.torredebatalla.cl/public_html/staging/  (document root)
//
// In that case:
//   __DIR__ is .../public_html/staging
//   app root is ../../laravel-app

$appRoot = __DIR__ . '/../../laravel-app';

if (file_exists($maintenance = $appRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appRoot . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appRoot . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
