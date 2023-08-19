<?php

namespace Prushak\Framework\Http;

readonly class Request {
    public function __construct(
        public array $get,
        public array $post,
        public array $cookie,
        public array $files,
        public array $server,
    )
    {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }
}