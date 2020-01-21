<?php

namespace Prerequisiter\Cli;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Config
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    static public function fromYamlFile(string $pathToYamlFile) : Config
    {
        try {
            $config = Yaml::parseFile($pathToYamlFile);
            if (!is_array($config)) {
                $config = [];
            }
        }
        catch (ParseException $e) {
            printf('Unable to parse config file ' . $pathToYamlFile . ': ' . $e->getMessage());
            $config = [];
        }

        

        return new static($config);
    }

    public function get()
    {
        return $this->config;
    }
}
