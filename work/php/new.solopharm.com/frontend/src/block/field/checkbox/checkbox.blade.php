<div class="{{ $block }} b-field">
    <input class="{{ $block->elem('field') }}" id="{{ isset($id) ? $id : $name }}" type="checkbox"
        name="{{ isset($name) ? $name : '' }}" {{ isset($checked) ? 'checked' : '' }}
        value="{{ isset($label) ? $label : '' }}" {{ isset($required) ? 'data-required=required' : '' }}>
    <label class="{{ $block->elem('label') }}"
        for="{{ isset($id) ? $id : $name }}"><span>{!! isset($label) ? $label : '' !!}</span></label>
    @if (isset($errors) || isset($required))
        <div class="{{ $block->elem('validate') }}">
            @isset($errors)
                <div class="errors">
                    @foreach ($errors as $error)
                        <p class="{{ $block->elem('error') }}">{!! $error !!}</p>
                    @endforeach
                </div>
            @endisset
        </div>
    @endif
</div>
