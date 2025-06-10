<div class="{{ $block }} b-field">
    <label class="{{ $block->elem('label') }}">
        <input class="{{ $block->elem('input') }}" type="file" name="{{ $name }}">
        @isset($icon)
            {!! $renderer->renderBlock('common/icon', [
                'icon' => $icon,
                'sprite' => $sprite ?? ''
            ]) !!}
        @endisset
        <span class="{{ $block->elem('text') }}">{!! $label !!}</span>
        <span class="{{ $block->elem('size') }}" data-size="{{ $size }}">(Не более {!! $size !!}
            МБ</span>
        <span class="{{ $block->elem('format') }}"data-format="{{ $format }}">{!! $format !!})</span>
    </label>
    <button class="{{ $block->elem('delete') }}" title="Удалить">
        {!! $renderer->renderBlock('common/icon', [
            'icon' => 'close',
        ]) !!}
    </button>
    <p class="{{ $block->elem('error') }}">{!! $error !!}</p>
</div>
