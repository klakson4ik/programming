<ul class="{{ $block }}">
    @foreach ($data as $name => $url)
        <li> <a href="{{ $url }}" target="_blank"> {!! $renderer->renderBlock('common/icon', [
            'sprite' => 'share',
            'icon' => $name,
        ]) !!}
            </a>
        </li>
    @endforeach
</ul>
