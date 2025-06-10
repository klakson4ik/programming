<div class="{{ $block->mod($mod ?? '') }}">

    <div class="{{ $block->elem('map') }}">
        @foreach ($items as $item)
            <div class="{{ $block->elem('map-dot') }}" data-country-id="{{ $item->id }}"
                style="top: {{ $item['top'] }}%; left: {{ $item['left'] }}%">
            </div>
        @endforeach
        <img class="{{ $block->elem('map-image') }}" src="/images/map-world.png" alt="Карта мира">
    </div>
    <div class="{{ $block->elem('list') }}">
        @foreach ($items as $item)
            <div class="{{ $block->elem('list-item') }}">
                <img class="{{ $block->elem('flag') }}" src="/images/flag/{{ strtolower($item->flag) }}.png"
                    alt="">
                <span class="{{ $block->elem('name') }}" data-country-id="{{ $item->id }}">
                    {{ $item->name }}
                </span>
            </div>
        @endforeach
    </div>
</div>
