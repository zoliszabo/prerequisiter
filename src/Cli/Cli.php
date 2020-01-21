<?php

namespace Prerequisiter\Cli;

use Symfony\Component\Console\Application;
use Prerequisiter\Cli\Command\PrerequisiterCommand;

class Cli
{
    public function __invoke()
    {
        $command = new PrerequisiterCommand();
        $application = new Application();
        $application->add($command);
        $application->setDefaultCommand($command->getName(), true);
        return $application->run();
    }
}
