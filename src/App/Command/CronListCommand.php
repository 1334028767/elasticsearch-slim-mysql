<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/7/17
 * Time: 16:11
 */

namespace App\Command;


use App\Component\Cron\Crontab;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronListCommand extends AppAwareCommand
{
	protected function configure()
	{
		$this->setName('peanut:cron:list')->setDescription('list all cron jobs');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$jobs = Crontab::getJobs();
		$output->writeln('cron jobs running: ' . count($jobs));
		foreach ($jobs as $job) {
			$output->writeln($job);
		}
	}
}