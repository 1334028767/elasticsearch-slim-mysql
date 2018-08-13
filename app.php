<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/14
 * Time: 12:31
 */

if (PHP_SAPI == 'cli-server') {
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = __DIR__ . $url['path'];
	if (is_file($file)) {
		return false;
	}
}

date_default_timezone_set('PRC');

require_once __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/config/config.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/src/dependencies.php';

// Register middleware
require __DIR__ . '/src/middleware.php';

// Register routes
require __DIR__ . '/src/routes.php';
