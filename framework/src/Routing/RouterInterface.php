<?php

namespace Prushak\Framework\Routing;

use Prushak\Framework\Http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface {
    public function dispatch(Request $request, ContainerInterface $container): array;
    public function setRoute(array $routes): void;
}