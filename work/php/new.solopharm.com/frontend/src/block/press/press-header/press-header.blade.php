<div class="{{ $block }}">
    <h1 class="c-h1">{!! $text !!}</h1>
    @if (locale() != 'en/')
        <a href="/about/news"class="{{ $block->elem('tab') }} @if ($type == 'news') active @endif">
            {{ $news }}
        </a>
        <a href="/about/presses" class="{{ $block->elem('tab') }} @if ($type == 'press') active @endif">
            {{ $press }}
        </a>
    @endif
</div>
