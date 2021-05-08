<?php

use JohnnyFreeman\LaravelTurbo\TurboStream;

if (! function_exists('turbo_stream')) {
    function turbo_stream()
    {
        return new TurboStream;
    }
}
