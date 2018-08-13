<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/7/17
 * Time: 17:48
 */

namespace App;


trait AppDirTrait
{
	protected function getRootDir()
	{
		return __DIR__ . '/../..';
	}

	protected function getVarDir()
	{
		return $this->getRootDir() . '/var';
	}

	protected function getPidDir()
	{
		$dir = $this->getCronLogDir() . '/pid';
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		return $dir;
	}

	protected function getCronLogDir()
	{
		$dir = $this->getVarDir() . '/cron';
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		return $dir;
	}
}