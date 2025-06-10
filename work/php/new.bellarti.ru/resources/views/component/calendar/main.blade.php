@php
    $block = 'b-calendar';
@endphp
<div class="{{ $block }}">
    <div class="{{ $block }}__header">
        <div class="{{ $block }}__control">
            <button class="c-trans-bg c-purple-dark {{ $block }}__prev">{!! $arrow !!}</button>
            <button class="c-trans-bg c-purple-dark {{ $block }}__next">{!! $arrow !!}</button>
        </div>
        <div class="{{ $block }}__select">
            @include('component.select', [
                'items' => $items,
                'selected' => $selected,
                'icon' => $arrowDropdown,
                'event' => 'date',
            ])
        </div>
    </div>
    <div class="{{ $block }}__content">
        @include('component.calendar.content')
    </div>
</div>
