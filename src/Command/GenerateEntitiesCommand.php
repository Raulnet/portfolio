<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 24/06/15
 * Time: 21:32
 */

namespace portfolio\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use portfolio\Command\Generator\Generator;

class GenerateEntitiesCommand extends Command {

    protected function configure()
    {
        $this
            ->setName('generate:entities')
            ->setDescription('Entities Generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = new Generator();
        $files = $generator->generate();

            foreach($files as $file){
                $output->writeln('<info>'.$file.'</info>');
            }

        $output->writeln('Done !!!');
    }

}