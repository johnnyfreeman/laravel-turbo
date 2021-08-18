<?php

use Illuminate\Container\Container;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use JohnnyFreeman\LaravelTurbo\TurboStream;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Compilers\ComponentTagCompiler;

if (! function_exists('turbo_stream')) {
    function turbo_stream($status = 200, array $headers = [])
    {
        return new TurboStream($status, $headers);
    }
}

if (! function_exists('blade')) {
    function blade(string $contents, array $data = []): ViewContract
    {
        View::addNamespace(
            '__blade',
            $directory = Config::get('view.compiled')
        );

        if (! is_file($viewFile = $directory.'/'.sha1($contents).'.blade.php')) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($viewFile, $contents);
        }

        return View::make('__blade::'.basename($viewFile, '.blade.php'), $data);
    }
}

if (! function_exists('component')) {
    function component(string $componentClass, array $data = []): ViewContract
    {
        [$data, $attributes] = (new ComponentTagCompiler(
            Container::getInstance()->make('blade.compiler')->getClassComponentAliases(),
            Container::getInstance()->make('blade.compiler')->getClassComponentNamespaces(),
            Container::getInstance()->make('blade.compiler')
        ))->partitionDataAndAttributes($componentClass, $data);

        $component = Container::getInstance()->make($componentClass, $data->toArray())
            ->withAttributes($attributes->toArray());

        $view = value($component->resolveView(), $data->toArray());

        return $view instanceof \Illuminate\View\View
            ? $view->with($component->data())
            : View::make($view, $component->data());
    }
}