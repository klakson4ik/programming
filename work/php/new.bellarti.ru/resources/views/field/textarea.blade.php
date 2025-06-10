<div class="b-textarea b-input">
    <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}"
        cols="{{ $cols ?? '' }}" rows="{{ $rows ?? '' }}" @if ($required) required @endif
        class="c-border-gray-light textarea">
</textarea>
    <div class="field-error">
    </div>
</div>
