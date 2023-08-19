<?php

declare(strict_types=1);

use Prushak\Framework\Http\Request;

define('MAIN_PATH', dirname(__DIR__));

require_once MAIN_PATH . "/vendor/autoload.php";

// request received
$request = Request::createFromGlobals();

// some logic
$kernel = new Kernel();

// send response (string of content)
$response = $kernel->handle($request);





