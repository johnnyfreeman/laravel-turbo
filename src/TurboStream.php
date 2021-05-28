<?php

namespace JohnnyFreeman\LaravelTurbo;

use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;

class TurboStream implements Htmlable, Renderable, Responsable
{
    public $status = 200;

    public $headers = [
        "Content-Type" => "{Turbo::CONTENT_TYPE}; charset=utf-8"
    ];

    public $streams = [];

    public function __construct($status = 200, array $headers = [])
    {
        $this->status = $status;
        $this->headers = array_merge($this->headers, $headers);
    }

    public function append($target, $view)
    {
        return $this->stream('append', $target, $view);
    }

    public function prepend($target, $view)
    {
        return $this->stream('prepend', $target, $view);
    }

    public function replace($target, $view)
    {
        return $this->stream('replace', $target, $view);
    }

    public function update($target, $view)
    {
        return $this->stream('update', $target, $view);
    }

    public function remove($target, $view)
    {
        return $this->stream('remove', $target, $view);
    }

    public function stream($action, $target, $view)
    {
        array_push($this->streams, compact('action', 'target', 'view'));

        return $this;
    }

    public function toHtml()
    {
        return $this->__toString();
    }

    public function render()
    {
        return $this->__toString();
    }

    public function toResponse($request)
    {
        return Response::make(
            $this->__toString(),
            $this->status,
            $this->headers
        );
    }

    public function __toString()
    {
        return (string) view('turbo::turbo-streams', [
            'streams' => $this->streams
        ]);
    }
}
