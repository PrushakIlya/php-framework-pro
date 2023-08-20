<?php

//declare(strict_types=1);

use Prushak\Framework\Http\Kernel;
use Prushak\Framework\Http\Request;
use Prushak\Framework\Routing\Router;

define('MAIN_PATH', dirname(__DIR__));

require_once MAIN_PATH . "/vendor/autoload.php";

// request received
$request = Request::createFromGlobals();

$router = new Router();
$kernel = new Kernel($router);

// send response (string of content)
$response = $kernel->handle($request);

$response->send();




