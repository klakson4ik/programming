@if (isset($type) && $type == 'button')
    <button class="{{ $block->mod(isset($left) ? 'left' : 'right') }}" type="button">
        {!! $renderer->renderBlock('common/icon', [
            'icon' => isset($left ) ? 'arrow-left' : 'arrow-right',
        ]) !!}
    </button>
@else
    <a class="{{ $block->mod(isset($left) ? 'left' : 'right') }}" href="{{ isset($url) ? $url : '#' }}">
        {!! $renderer->renderBlock('common/icon', [
            'icon' => isset($left ) ? 'arrow-left' : 'arrow-right',
        ]) !!}
    </a>
@endif
