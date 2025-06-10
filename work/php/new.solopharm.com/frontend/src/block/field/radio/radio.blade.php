<div class="{{ $block }} b-field">
    <p class="{{ $block->elem('caption')->mod($captionStyle ?? '') }}">{!! isset($caption) ? $caption : '' !!}</p>
    <div class="{{ $block->elem('row') }}">
        @foreach ($fields as $key => $field)
            <div class="{{ $block->elem('column')->mod(isset($field['input']['style']) ? '' : (isset($field['input']) ? 'flex' : '')) }}">
                <input class="{{ $block->elem('field') }}" id="{{ $name . '-' . $field['name'] }}" type="radio"
                    name="{{ $name }}" {{ $key == 0 ? 'checked' : '' }} value="{{ $field['label'] }}">
                <label class="{{ $block->elem('label') }}"
                    for="{{ $name . '-' . $field['name'] }}"><span>{{ isset($field['label']) ? $field['label'] : '' }}</span></label>
                @isset($field['input'])
                    <input class="{{ $block->elem('input-inside')->mod($field['input']['style'] ?? '') }}" id="{{ $field['input']['id'] ?? $field['input']['name'] }}"
                        type="{{ $field['input']['type'] ?? 'text' }}" name="{{ $field['input']['name'] ?? '' }}"
                        value="{{ $field['input']['value'] ?? '' }}"
                        placeholder="{{ $field['input']['placeholder'] ?? '' }}">
                @endisset
            </div>
        @endforeach
    </div>
    @isset($errors)
        <div class="{{ $block->elem('errors') }}">
            @foreach ($errors as $error)
                <p class="{{ $block->elem('error') }}">{!! $error !!}</p>
            @endforeach
        </div>
    @endisset
</div>
