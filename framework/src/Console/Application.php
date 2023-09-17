<?php

namespace Prushak\Framework\Console;

use Prushak\Framework\Console\Exception\NoCommandNameException;
use Psr\Container\ContainerInterface;

class Application
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function run(): int
    {
        $argv = $_SERVER['argv'];

        $commandName = $argv[1] ?? null;

        if (!$commandName) {
            throw new NoCommandNameException();
        }

        $argvs = array_slice($argv, 2);

        $params = $this->argvParse($argvs);

        $command = $this->container->get($commandName);

        $status = $command->execute($params);

        return $status;
    }

    private function argvParse(array $argvs): array
    {
        $params = [];

        foreach ($argvs as $argv) {
            if (str_starts_with($argv, '--' )) {
                $option = explode('=', mb_substr($argv, 2));
                $params[$option[0]] = $option[1] ?? true;
            }
        }

        return $params;
    }
}