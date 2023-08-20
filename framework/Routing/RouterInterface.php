<?php

namespace Prushak\Framework\Routing;

use Prushak\Framework\Http\Request;

interface RouterInterface {
    public function dispatch(Request $request): array;
}