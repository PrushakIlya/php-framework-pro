<?php

use Prushak\Framework\Http\Request;
use Prushak\Framework\Http\Response;

class Kernel {
    public function handle(Request $request): Response {
        $content = "Hello World";

        return new Response($content);
    }
}