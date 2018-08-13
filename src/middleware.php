<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \Tuupola\Middleware\HttpBasicAuthentication([
	"path" => ["/"],
	"passthrough" => [],
	"realm" => "Protected",
	"relaxed" => ["localhost"],
	"authenticator" => function ($arguments) use ($app) {

		$container = $app->getContainer();
		$settings = $container['settings'];
		if ($settings['debug'] == true) {
			return true;
		}

		$host = $_SERVER['HTTP_HOST'];
		if (strpos($host, 'localhost') === 0) {
			return true;
		}

		$user = $arguments['user'];
		$password = $arguments['password'];
		return $user == 'peanut' && $password == 'peanutstats';
	},
	"error" => function ($response, $arguments) {
		$data = [];
		$data["status"] = "error";
		$data["message"] = $arguments["message"];
		return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
	}
]));