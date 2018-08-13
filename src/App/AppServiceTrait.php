<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/14
 * Time: 12:41
 */

namespace App;

use App\Service\SendService;

trait AppServiceTrait
{
	use AppDependencyTrait;

	protected function sendService()
	{
		return $this->get('app.service.send');
	}

    private function get($key)
	{
		try {
			$service = $this->container()->get($key);
		} catch (\Exception $e) {
			$service = null;
		}

		if (!$service) {
			$service = $this->initService($key);
			if ($service) {
				$this->setModule($key, $service);
			}
		}
		return $service;
	}

	private function setModule($key, $service)
	{
		$container = $this->container();
		if ($container) {
			$container[$key] = $service;
		}
	}

	private function initService($key)
	{
		if ($key == 'app.service.send') {
			return new SendService($this->elasticsearch());
		}

		return null;
	}
}