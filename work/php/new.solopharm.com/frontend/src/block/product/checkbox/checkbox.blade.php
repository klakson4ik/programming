<input
    class="{{ $block->mod($mod ?? '') }}"
    id="{{ isset($id) ? $id : '' }}"
    type="checkbox"
    name="{{ isset($name) ? $name : '' }}"
    {{ $checked ? 'checked' : '' }}
    value="{{ isset($value) ? $value : '' }}"
    @if(isset($parent) && ($parent === true))
        data-parent
    @endif
>
<label for="{{ isset($id) ? $id : '' }}">
    <span>{{ isset($text) ? $text : '' }}</span>
    @if(isset($parent) && ($parent === true))
        <i class="{{ $block->elem('dropdown-icon') }}">
            {!! $renderer->renderBLock('common/icon', [
                'icon' => 'arrow-short',
            ]) !!}
        </i>
    @endif
</label>
