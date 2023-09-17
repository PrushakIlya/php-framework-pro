<?php

namespace Prushak\Framework\Http;

use Doctrine\DBAL\Connection;
use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class Kernel {
    private string $debug_mode;

    public function __construct(
        private RouterInterface $router,
        private ContainerInterface $container
    )
    {
        $this->debug_mode = $this->container->get('debug_mode');
    }

     public function handle(Request $request): Response {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routeHandler, $vars);
        }
        catch(\Exception $e) {
           $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $exception)
    {
        if (in_array($this->debug_mode, ['dev', 'test'])) {
            throw $exception;
        }

        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getCode());
        }

        return new Response('Server Error', Response::HTTP_SERVER_ERROR);
    }
}