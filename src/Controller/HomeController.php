<?php

namespace App\Controller;

use Prushak\Framework\Http\Response;

class HomeController {
    public function index(int $id): Response
    {
        return new Response('Hello');
    }
}