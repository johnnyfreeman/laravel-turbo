<?php

namespace JohnnyFreeman\LaravelTurbo;

class Turbo
{
    public static function stream($status = 200, array $headers = [])
    {
        return new TurboStream($status, $headers);
    }
}
