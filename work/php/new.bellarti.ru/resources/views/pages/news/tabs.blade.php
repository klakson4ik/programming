@php
	$block = 'b-tabs';
@endphp
<nav class="{{ $block }}">
    <ul class="{{ $block }}__list">
        @foreach ($tabs as $tab)
            <li class="c-trans-bg c-trans-color {{ $block }}__item">
                <a href="{{ $tab['link'] }}"
                    class="c-font-tab c-black c-border-black c-trans-bg-and-color {{ $tab['active'] }} {{ $block }}__link">
                    {!! $tab['caption'] !!}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
