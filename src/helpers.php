<?php

use JohnnyFreeman\LaravelTurbo\TurboStream;

if (! function_exists('turbo_stream')) {
    function turbo_stream($status = 200, array $headers = [])
    {
        return new TurboStream($status, $headers);
    }
}
