<?php
namespace JohnnyFreeman\LaravelTurbo;

use Illuminate\Contracts\Support\Responsable;

class TurboStream implements Responsable
{
    public $streams = [];

    public function append($target, $view, $data)
    {
        return $this->stream('append', $target, $view, $data);
    }
    
    public function prepend($target, $view, $data)
    {
        return $this->stream('prepend', $target, $view, $data);
    }

    public function replace($target, $view, $data)
    {
        return $this->stream('replace', $target, $view, $data);
    }

    public function update($target, $view, $data)
    {
        return $this->stream('update', $target, $view, $data);
    }

    public function remove($target, $view, $data)
    {
        return $this->stream('remove', $target, $view, $data);
    }

    public function stream($action, $target, $view, $data)
    {
        array_push($this->streams, [
            'action' => $action,
            'target' => $target,
            'view' => $view,
            'data' => $data,
        ]);

        return $this;
    }

    public function toResponse($request) {
        return response()->view('common.turbo-streams', [
            'streams' => $this->streams
        ])->header('Content-Type', static::CONTENT_TYPE . '; charset=utf-8');
    }
}
