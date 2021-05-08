@foreach($streams as $stream)
<turbo-stream action="{{ $stream['action'] }}" target="{{ $stream['target'] }}">
    <template>
        @include($stream['view'], $stream['data'])
    </template>
</turbo-stream>
@endforeach