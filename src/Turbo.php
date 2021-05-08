<?php
namespace JohnnyFreeman\LaravelTurbo;

class Turbo
{
    public const CONTENT_TYPE = 'text/vnd.turbo-stream.html';

    public static function stream()
    {
        return new TurboStream;
    }
}
