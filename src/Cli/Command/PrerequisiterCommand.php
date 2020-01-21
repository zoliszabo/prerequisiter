<?php

namespace Prerequisiter\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Prerequisiter\Cli\Config;
use Prerequisiter\Checker\CheckerFactory;
use Prerequisiter\Checker\CheckerResponse;

class PrerequisiterCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Runs Prerequisiter checks.');

        $this
            ->addOption('config', 'c', InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getOption('config');
        if (empty($configFile)) {
            $configFile = 'prerequisiter.yaml';
        }
        if (!file_exists($configFile)) {
            $output->writeln('<error>Config file not found: ' . $configFile . '.</error>');
            return 1579607202;
        }
        $config = Config::fromYamlFile($configFile)->get();
        if (empty($config)) {
            $output->writeln('<error>Config file could not be parsed or is empty: ' . $configFile . '.</error>');
            return 1579609284;
        }

        $returnCode = 0;
        foreach($config as $checkType => $configByCheckType) {
            foreach($configByCheckType as $objectType => $objects) {
                $output->writeln('Checking <options=underscore>' . $checkType . ' ' . $objectType . '</>...');
                $checker = CheckerFactory::createChecker($objectType);
                foreach($objects as $object) {
                    $response = $checker->check($object);
                    if (($checkType === 'required') && !$response->result) {
                        $returnCode = 1;
                    }
                    $output->writeln($this->outputifyCheckerResponse($response, $checkType, $object));
                }
            }
        }

        return $returnCode;
    }

    private function outputifyCheckerResponse(CheckerResponse $response, string $checkType, string $object) : string
    {
        $messageType = NULL;
        if ($response->result) {
            $messageType = '<fg=green>';
        }
        else {
            switch($checkType) {
                case 'required':
                    $messageType = '<fg=red>';
                    break;
                case 'optional':
                default:
                    $messageType = '<fg=yellow>';
                    break;
            }
        }
        return ' - ' . $object . ': ' . ($messageType ?: '') . $response->message . ($messageType ? '</>': '');
    }
}
