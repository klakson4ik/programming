<input
    class="{{ $block }}"
    id="{{ isset($id) ? $id : '' }}"
    type="checkbox" name="{{ isset($name) ? $name : '' }}"
    {{ $checked ? 'checked' : '' }}
    value="{{ isset($value) ? $value : '' }}"
    @if(isset($parent) && ($parent === true))
        data-parent
        disabled="true"
    @endif
    @isset($mod)
        data-mod="{{ $mod }}"
    @endisset
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
