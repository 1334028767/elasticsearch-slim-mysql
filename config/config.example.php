<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/7/5
 * Time: 19:02
 */

return [
	'settings' => [
		'displayErrorDetails'    => true, // set to false in production
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header
		'debug' => true,

		// Monolog settings
		'logger'                 => [
			'name'  => 'app',
			'path'  => __DIR__ . '/../var/logs/app/' . date('Y-m-d', time()) . '.log',
			'level' => \Monolog\Logger::DEBUG,
		],

		'mysql'         => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'database' => 'yy',
			'username' => 'root',
			'password' => '',
			'charset'   => 'utf8',
		],

		'elasticsearch' => [
			'hosts'  => [
				[
					'host' => '127.0.0.1',
					'port' => '9200',
					'user' => 'user',
					'pass' => 'pass',
				],
			],
			'logger' => [
				'name'  => 'elasticsearch',
				'path'  => __DIR__ . '/../var/logs/es/' . date('Y-m-d', time()) . '.log',
				'level' => \Monolog\Logger::DEBUG,
			],
		],
	],
];