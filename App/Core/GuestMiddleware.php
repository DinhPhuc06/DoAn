<?php

namespace App\Core;


class GuestMiddleware extends Middleware
{
    protected string $homeUrl = '/';

    public function handle(\Closure $next): void
    {
        if (!Auth::check()) {
            $next();
            return;
        }

        $url = defined('APP_URL') ? rtrim(APP_URL, '/') . $this->homeUrl : $this->homeUrl;
        header('Location: ' . $url);
        exit;
    }
}
