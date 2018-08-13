<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/7/17
 * Time: 14:51
 */

namespace App\Component\Cron;


class Crontab
{
// In this class, array instead of string would be the standard input / output format.

	// Legacy way to add a job:
	// $output = shell_exec('(crontab -l; echo "'.$job.'") | crontab -');

	private static function stringToArray($jobs = '')
	{
		if (strpos($jobs, "\r\n") !== false) {
			$array = explode("\r\n", trim($jobs)); // trim() gets rid of the last \r\n
		}
		else {
			$array = explode("\n", trim($jobs)); // trim() gets rid of the last \r\n
		}

		foreach ($array as $key => $item) {
			if ($item == '') {
				unset($array[$key]);
			}
		}

		return $array;
	}

	private static function arrayToString($jobs = [])
	{
		$string = implode("\r\n", $jobs);

		return $string;
	}

	public static function getJobs()
	{
		$output = shell_exec('crontab -l');

		return self::stringToArray($output);
	}

	public static function saveJobs($jobs = [])
	{
		$output = shell_exec('echo "' . self::arrayToString($jobs) . '" | crontab -');

		return $output;
	}

	public static function doesJobExist($job = '')
	{
		$jobs = self::getJobs();
		if (in_array($job, $jobs)) {
			return true;
		} else {
			return false;
		}
	}

	public static function addJob($job = '')
	{
		if (self::doesJobExist($job)) {
			return false;
		} else {
			$jobs   = self::getJobs();
			$jobs[] = $job;

			return self::saveJobs($jobs);
		}
	}

	public static function removeJob($job = '')
	{
		if (self::doesJobExist($job)) {
			$jobs = self::getJobs();
			unset($jobs[array_search($job, $jobs)]);

			return self::saveJobs($jobs);
		} else {
			return false;
		}
	}
}