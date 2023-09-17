<?php

namespace Prushak\Framework\Console\Command;

interface CommandInterface {
    public function execute(array $params): int; // php bin/console database:migration:migrate
}