<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark">{!! $title !!}</h2>
    @if (!empty($cities))
        <div class="c-bg-purple-light-very {{ $block }}__select">
            @include('component.select', [
                'items' => $cities,
                'selected' => $selects['city']['selected'],
                'icon' => $selects['city']['arrow'],
                'event' => 'ymap-city',
            ])
        </div>
    @endif
    @if ($ymapKey)
        <div class="{{ $block }}__location">
            <div id="ymap" class="{{ $block }}__map">
                <div class="balloon-container">
                </div>
            </div>
            <script src="https://api-maps.yandex.ru/2.1/?apikey={{ $ymapKey }}&load=package.full&lang=ru_RU"
                type="text/javascript"></script>
        </div>
    @endif
</section>
