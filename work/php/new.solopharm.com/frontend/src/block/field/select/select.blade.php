<div class="{{ $block }} b-field">
    @isset($label)
        <label class="{{ $block->elem('label') }}" for="{{ isset($id) ? $id : $name }}">
            {!! $label !!}
            @isset($required)
                <span class="{{ $block->elem('label-required') }}">*</span>
            @endisset
        </label>
    @endisset
    <div class="{{ $block->elem('select-container') }}">
        <select class="{{ $block->elem('field') }}" id="{{ isset($id) ? $id : $name }}"
            name="{{ isset($name) ? $name : '' }}" {{ isset($required) ? 'required' : '' }}>
            @if (!isset($noEmpty))
                <option class="{{ $block->elem('default') }}" value="{{ __('form.select.default') }}" selected>
                    {{ __('form.select.default') }}</option>
            @endif
            @foreach ($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
    </div>
    @isset($errors)
        <div class="{{ $block->elem('errors') }}">
            @foreach ($errors as $error)
                <p class="{{ $block->elem('error') }}">{!! $error !!}</p>
            @endforeach
        </div>
    @endisset
</div>
