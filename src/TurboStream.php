<?php
namespace JohnnyFreeman\LaravelTurbo;

use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Support\Responsable;

class TurboStream implements Responsable
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

    public function toResponse($request)
    {
        return Response::view(
            'turbo::turbo-streams',
            ['streams' => $this->streams],
            $this->status,
            $this->headers
        );
    }
}
