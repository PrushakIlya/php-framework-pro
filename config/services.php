<?php

$container = new \League\Container\Container();

#parameters for application config

$routes = require_once MAIN_PATH . '/routes/web.php';
$app_env = $_ENV['APP_ENV'];
$template_path = MAIN_PATH . '/templates';
$database_url = 'sqlite:///' . MAIN_PATH . '/var/db.sqlite';

$container->add('debug_mode', $app_env);
$container->add('template_path', $template_path);

#services

$container->delegate(new \League\Container\ReflectionContainer(true));

$container->add('base-commands-namespace', 'Prushak\Framework\Console\Command\\');

$container->add(
    \Prushak\Framework\Routing\RouterInterface::class,
    \Prushak\Framework\Routing\Router::class
);

$container->extend(\Prushak\Framework\Routing\RouterInterface::class)->addMethodCall(
    'setRoute',
    [$routes]
);

$container->add(\Prushak\Framework\Http\Kernel::class)
    ->addArgument(\Prushak\Framework\Routing\RouterInterface::class)
    ->addArgument($container);

$container->add(\Prushak\Framework\Console\Kernel::class)
    ->addArguments([$container, \Prushak\Framework\Console\Application::class]);

$container->add(\Prushak\Framework\Console\Application::class)
    ->addArgument($container);

$container->add('twig-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument($template_path);

$container->add('twig', \Twig\Environment::class)
    ->addArgument('twig-loader');

$container->inflector(\Prushak\Framework\Controller\AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$container->add(\Prushak\Framework\Dbal\ConnectionFactory::class)
    ->addArgument($database_url);

$container->add(\Doctrine\DBAL\Connection::class, function () use ($container): \Doctrine\DBAL\Connection {
    return $container->get(\Prushak\Framework\Dbal\ConnectionFactory::class)->create();
});

return $container;