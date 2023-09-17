<?php

namespace Prushak\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Prushak\Framework\Container\Container;
use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Exception\HttpRequestMethodException;
use Prushak\Framework\Http\Request;
use Psr\Container\ContainerInterface;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface {
    private array $routes;
    public function dispatch(Request $request, ContainerInterface $container): array
    {
        [$routeHandler, $vars] = $this->getRouteInfo($request);

        if (is_array($routeHandler)) {
            [$controllerId, $method] = $routeHandler;
            $controller = $container->get($controllerId);
            $routeHandler = [$controller, $method];
        }

        return [$routeHandler, $vars];
    }

    public function setRoute(array $routes): void {
        $this->routes = $routes;
    }

    private function getRouteInfo(Request $request): array | HttpException
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $roteInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        switch ($roteInfo[0]) {
            case Dispatcher::FOUND:
                [$status, $routeHandler, $vars] = $roteInfo;
                return [$routeHandler, $vars];
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new HttpRequestMethodException();
            default:
                throw new HttpException();
        }
    }
}