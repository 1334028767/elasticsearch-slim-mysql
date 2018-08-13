<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/7/17
 * Time: 16:42
 */

namespace App\Command;


use App\Component\Cron\Crontab;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronStopCommand extends AppAwareCommand
{
	protected function configure()
	{
		$this->setName('peanut:cron:stop')->setDescription('suspend all cron jobs to crontab');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$allJobs    = Crontab::getJobs();
		$jobsToRun  = [];
		$jobsToStop = [];
		foreach ($allJobs as $job) {
			if (strpos($job, 'peanut-stats') === false) {
				$jobsToRun[] = $job;
			} else {
				$jobsToStop[] = $job;
			}
		}

//		$jobsToStop[] = '/usr/local/opt/php@7.1/bin/php /Users/imhui/www/peanut/peanut-stats/bin/console cron:test -e=prod > /dev/null';
		$output->writeln('cron jobs to stop: ' . count($jobsToStop));
		Crontab::saveJobs($jobsToRun);
		$this->waitJobsFinish($jobsToStop, $output);
	}

	private function waitJobsFinish($jobs, OutputInterface $output)
	{
		if (empty($jobs)) {
			return;
		}

		foreach ($jobs as $job) {
			$pattern = '/peanut:cron:\S+\s/';
			$result  = preg_match($pattern, $job, $matchs);
			if ($result !== false && !empty($matchs)) {
				$command = trim($matchs[0]);
				if ($this->isCommandRunning($command)) {
					$output->writeln('[' . $command . '] is running...');
					$pidfile = $this->getCommandPidFile($command);
					$output->write("waiting...");
					while (file_exists($pidfile)) {
						sleep(1);
					}
					$output->writeln("\n[" . $command . "] finish running");
				}
			}
		}
	}
}