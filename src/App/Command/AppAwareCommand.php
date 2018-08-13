<?php
/**
 * Created by PhpStorm.
 * User: imhui
 * Date: 2018/6/25
 * Time: 16:03
 */

namespace App\Command;


use App\AppDirTrait;
use App\AppServiceTrait;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;

abstract class AppAwareCommand extends Command
{
	use AppServiceTrait;
	use AppDirTrait;

	protected $container;

	/**
	 * @var LoggerInterface
	 */
	protected $cronLogger;

	/**
	 * @param mixed $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}

	protected function getCommandPidFile($command)
	{
		$command = 'cmd_' . str_replace(':', '-', $command);

		return $this->getPidDir() . '/' . $command . '.pid';
	}

	protected function isCommandRunning($command)
	{
		$pidfile = $this->getCommandPidFile($command);

		return file_exists($pidfile);
	}

	protected function startCommand($command)
    {
        file_put_contents($this->getCommandPidFile($command), getmypid());
    }

    protected function endCommand($command)
    {
        @unlink($this->getCommandPidFile($this->getName()));
    }


	/**
	 * @return Logger|LoggerInterface
	 * @throws \Exception
	 */
	protected function cronLogger()
	{
		if (!$this->cronLogger) {
			$name = str_replace(':', '-', $this->getName());
			$logger = new Logger($name);
			$logger->pushProcessor(new UidProcessor());
			$path = $this->getCronLogDir() . '/logs/' . $name . date('Y-m-d', time()) . '.log';
			$logger->pushHandler(new StreamHandler($path, Logger::DEBUG));
			$this->cronLogger = $logger;
		}
		return $this->cronLogger;
	}
}