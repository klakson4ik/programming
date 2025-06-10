<div class="{{ $block->mod($mod ?? '') }} b-field">
    @isset($label)
        <label class="{{ $block->elem('label') }}" for="{{ $id ?? $name }}">{!! $label !!}{!! isset($required) ? ' <span class="' . $block->elem('label-required') . '">*</span>' : '' !!}</label>
    @endisset
        <textarea class="{{ $block->elem('field') }}" id="{{ $id ?? $name }}"
        name="{{ $name ??'' }}" {{ isset($required) ? 'data-required=true' : '' }}
        {{ isset($pattern) ? 'data-pattern=' . $pattern : '' }}
        {{ isset($rows) ? 'rows=' .$rows : '' }} {{ isset($cols) ? 'cols=' . $cols : ''}}>{!! $value ?? '' !!}</textarea>
    @if (isset($errors) || isset($required))
        <div class="{{ $block->elem('validate') }}">
            @isset($errors)
                <div class="errors">
                    @foreach ($errors as $key => $error)
                        <p class="{{ $block->elem($key) }}">{!! $error !!}</p>
                    @endforeach
                </div>
            @endisset
            @isset($required)
                <p class="required">{!! __('form.errors.required') !!}</p>
            @endisset
        </div>
    @endif
</div>
