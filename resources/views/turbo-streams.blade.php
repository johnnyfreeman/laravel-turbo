@foreach($streams as $stream)
<turbo-stream action="{{ $stream['action'] }}" target="{{ $stream['target'] }}">
    <template>
        @if ($stream['view'] instanceof Illuminate\Contracts\Support\Renderable)
            {!! $stream['view']->render() !!}
        @elseif ($stream['view'] instanceof Illuminate\Contracts\Support\Htmlable)
            {!! $stream['view']->toHtml() !!}
        @else
            {!! $stream['view'] !!}
        @endif
    </template>
</turbo-stream>
@endforeach