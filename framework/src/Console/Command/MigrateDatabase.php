<?php

namespace Prushak\Framework\Console\Command;

class MigrateDatabase implements CommandInterface
{
    public string $name = 'database:migration:migrate';

    public function execute(array $params = []): int
    {
        dd($params);

        echo get_class() . 'MigrateDatabase';

        return 0;
    }
}