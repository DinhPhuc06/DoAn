<?php

namespace App\Core;


abstract class Middleware
{
  
    abstract public function handle(\Closure $next): void;

 
    public static function run(\Closure $next, string $middlewareClass): void
    {
        $middleware = new $middlewareClass();
        $middleware->handle($next);
    }
}
