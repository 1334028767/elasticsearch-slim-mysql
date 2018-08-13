<?php
// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {

	$settings = $c->get('settings')['logger'];
	$logger   = new Monolog\Logger($settings['name']);
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

	return $logger;
};

// elasticsearch
/*$container['elasticsearch'] = function ($c) {

	$settings        = $c->get('settings')['elasticsearch'];
	$logger_settings = $settings['logger'];

	$logger = \Elasticsearch\ClientBuilder::defaultLogger($logger_settings['path'], $logger_settings['level']);
	$client = \Elasticsearch\ClientBuilder::create()->setHosts($settings['hosts'])->setRetries(0)
	                                      ->setLogger($logger)->build();

	return $client;
};

$container['mysql'] = function ($c) {

    $settings = $c->get('settings')['mysql'];
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($settings);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};*/

