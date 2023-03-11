<?php

namespace JohnnyFreeman\LaravelTurbo;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View as ViewContract;

class TurboStream implements Htmlable, Renderable, Responsable
{
    public const CONTENT_TYPE = 'text/vnd.turbo-stream.html';

    public array $streams = [];

    public function __construct(
        public int $status = 200,
        public array $headers = [],
    ) {
        $this->headers = array_merge([
            'Content-Type' => self::CONTENT_TYPE . '; charset=utf-8'
        ], $headers);
    }

    public function append($target, $view): static
    {
        return $this->stream('append', $target, $view);
    }

    public function prepend($target, $view): static
    {
        return $this->stream('prepend', $target, $view);
    }

    public function replace($target, $view): static
    {
        return $this->stream('replace', $target, $view);
    }

    public function update($target, $view): static
    {
        return $this->stream('update', $target, $view);
    }

    public function remove($target, $view): static
    {
        return $this->stream('remove', $target, $view);
    }

    public function stream($action, $target, $view): static
    {
        array_push($this->streams, compact('action', 'target', 'view'));

        return $this;
    }

    public function toHtml(): string
    {
        return $this->toView()->render();
    }

    public function toView(): ViewContract
    {
        return View::make('turbo::turbo-streams', [
            'streams' => $this->streams
        ]);
    }

    public function render(): string
    {
        return $this->toHtml();
    }

    public function toResponse($request)
    {
        return Response::make(
            $this->__toString(),
            $this->status,
            $this->headers
        );
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }
}
