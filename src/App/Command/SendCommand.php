<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 2018/6/28
 * Time: 10:26
 */

namespace App\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendCommand extends AppAwareCommand
{
    protected function configure()
    {
        $this->setName('notice:send')->setDescription('send notice');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cronLogger()->info('send notice start');

        $res = $this->SendService()->sendNotice();

        $output->writeln("OK");
        if (isset($res)) {
            $this->cronLogger()->info($res);
        }
    }


}