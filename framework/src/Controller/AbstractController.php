<?php

namespace Prushak\Framework\Controller;

use Prushak\Framework\Http\Response;
use Psr\Container\ContainerInterface;

class AbstractController {
    protected ?ContainerInterface $container;
    const EXTANTIONS = [
        'twig',
        'html',
    ];

    public function setContainer(ContainerInterface $container) {
       $this->container = $container;
    }

    protected  function render(string $template, array $parameters = []): Response
    {
       $template = $this->container->get('twig')->render($template, $parameters);

        return new Response($template);
    }
}