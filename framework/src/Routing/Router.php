<?php

namespace Prushak\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Exception\HttpRequestMethodException;
use Prushak\Framework\Http\Request;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface {
    public function dispatch(Request $request): array
    {
        [$routeHandler, $vars] = $this->getRouteInfo($request);

        if (is_array($routeHandler)) {
            [$controller, $method] = $routeHandler;
            return [[new $controller, $method], $vars];
        }

        return [$routeHandler, $vars];
    }

    private function getRouteInfo(Request $request): array | HttpException
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) {
            $routes = require_once MAIN_PATH . '/routes/web.php';

            foreach ($routes as $route) {
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