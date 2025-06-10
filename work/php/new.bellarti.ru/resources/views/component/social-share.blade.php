@php
    $block = 'b-social-link';
@endphp

<div class="{{ $block }}">
    <p class="c-font-subtitle c-purple-dark {{ $block }}__title">{{ $socialShare['title'] }}</p>

    <ul class="{{ $block }}__wrapper">
        @foreach ($socialShare['info'] as $link)
            <li class="{{ $block }}__list">
                <a href="{{ $link['url'] }}" target="_blank" class="{{ $block }}__list-link">
                    {!! $link['img'] !!}
                </a>
            </li>
        @endforeach
    </ul>
</div>
