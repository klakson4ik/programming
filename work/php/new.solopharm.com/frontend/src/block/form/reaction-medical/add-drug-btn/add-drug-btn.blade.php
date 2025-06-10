<button class="{{ $block }}" name="{{ $name }}" data-count="1">
    {!! $renderer->renderBlock('common/icon', [
        'icon' => $icon,
        'sprite' => 'reaction',
    ]) !!}
    <span class="{{ $block->elem('text')}}">{!! $caption !!}</span>
</button>
