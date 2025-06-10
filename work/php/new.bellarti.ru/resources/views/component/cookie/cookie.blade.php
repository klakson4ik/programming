@php
    $block = 'b-cookie';
@endphp

<div class="{{ $block }} c-bg-purple ">
    <p class="{{ $block }}__title">Мы используем файлы cookie в соответствии с
        <a href="{{ getLink('/policy') }}" target="__blank" class="c-link {{ $block }}__link"> в отношении файлов
            cookie</a>, чтобы
        обеспечить лучшую работу с сайтом.
    </p>

    <button class="{{ $block }}__btn">
        {!! getIcon('/cookie/cookie.svg') !!}
    </button>
</div>
