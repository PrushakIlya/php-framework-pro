<?php

namespace Prushak\Framework\Http;

use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Exception\HttpRequestMethodException;
use Prushak\Framework\Routing\RouterInterface;

class Kernel {
    public function __construct(private RouterInterface $router)
    {
    }

     public function handle(Request $request): Response {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);

            $response = call_user_func_array($routeHandler, $vars);
        }
        catch(HttpException $e) {
            $response = new Response($e->getMessage(), $e->getCode());
        }
        catch(\Exception $e) {
            $response = new Response($e->getMessage(),  500);
        }

        return $response;
    }
}