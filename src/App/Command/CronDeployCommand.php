<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/7/17
 * Time: 16:20
 */

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Component\Cron\Crontab;

class CronDeployCommand extends AppAwareCommand
{
	protected function configure()
	{
		$this->setName('peanut:cron:deploy')
		     ->setDescription('deploy all cron jobs to crontab');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$cmdPHP = shell_exec('which php');
		if (!$cmdPHP || strpos($cmdPHP, 'no php') !== false) {
			$output->writeln('php: command not found');
			return;
		}

		$cmdPHP = trim($cmdPHP);
		$consolePath = __DIR__ . '/../../../bin/console';

        $job = "*/1 * * * * {$cmdPHP} {$consolePath} notice:send > /dev/null &";
        Crontab::addJob($job);

		$output->writeln('crob jobs added.');
		$jobs = Crontab::getJobs();
		foreach ($jobs as $job) {
			$output->writeln($job);
		}
	}


}