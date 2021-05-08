<?php

namespace JohnnyFreeman\LaravelTurbo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class TurboServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Request::macro('wantsTurboStream', function () {
            return Str::contains($this->headers->get('Accept'), Turbo::CONTENT_TYPE);
        });
    }
}
