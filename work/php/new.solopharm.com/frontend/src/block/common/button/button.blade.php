@if (isset($type) && $type == 'submit')
    <label class="{{ $block->mod('submit') }} submit">
        <input type="submit" value="{{ $text }}" name="{{ isset($name) ? $name : '' }}" />
        @if (isset($icon) && $icon)
            <span class="{{ $block->elem('icon') }}">
                {!! $renderer->renderBlock('common/icon', [
                    'icon' => $icon,
                ]) !!}
            </span>
        @endif
    </label>
@elseif(isset($type) && $type == 'button')
    <button class="{{ $block->mod('button') }}" type="button" name="{{ isset($name) ? $name : '' }}"
        @if (isset($data) && $data) @foreach ($data as $key => $value)
            data-{{ $key }}="{{ $value }}"
        @endforeach @endif>
        {!! $text !!}
        @if (isset($icon) && $icon)
            <span class="{{ $block->elem('icon') }}">
                {!! $renderer->renderBlock('common/icon', [
                    'icon' => $icon,
                ]) !!}
            </span>
        @endif
    </button>
@else
    <a class="{{ $block->mod('url') }}" href="{{ isset($url) ? $url : '#' }}" @isset($target) target="{{$target}}" @endisset>
        {!! $text !!}
        @if (isset($icon) && $icon)
            <span class="{{ $block->elem('icon') }}">
                {!! $renderer->renderBlock('common/icon', [
                    'icon' => $icon,
                ]) !!}
			<span>
        @endif
    </a>
@endif
