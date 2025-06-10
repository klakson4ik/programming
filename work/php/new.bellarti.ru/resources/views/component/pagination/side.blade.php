@php
    $block = 'b-pag-side';
@endphp
<div class="{{ $block }}">
    <nav class="{{ $block }}__nav">
        <ul class="{{ $block }}__list">
            @foreach ($data as $item)
                <li id="anchor-{{ $item['anchor']}}" class="{{ $block }}__item">
                    <a href="#{{ $item['anchor'] }}" class="c-black {{ $block }}__link">
                        {!! $item['caption'] !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>
