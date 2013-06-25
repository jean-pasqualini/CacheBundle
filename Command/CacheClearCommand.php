<?php

namespace Adibox\Bundle\CacheBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class CacheClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('entity:clear')
            ->setDescription('Clear all cache with entity cache')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Clear cache optimise entity render ... </info>');

        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        $connection = $em->getConnection();

        $stmt = $connection->prepare("TRUNCATE Cache;");
        $stmt->execute();

        /*
        $command = $this->getApplication()->find('cache:clear');

        $arguments = array(
            "--env" => "prod"
        );

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);
        */
    }
}
