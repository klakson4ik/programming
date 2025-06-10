<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark {{ $block }}__title">{{ $title }}</h2>
    <div class="{{ $block }}__region">
        <p class="{{ $block }}__region-title">{{ $region }}</p>
        <div class="c-bg-purple-light-very {{ $block }}__column {{ $block }}__column--districts">
            @include('component.select', [
                'items' => $districts,
                'selected' => $selects['info']['selected'],
                'icon' => $selects['info']['arrow'],
                'event' => 'districts',
            ])
        </div>
    </div>
    <div class="{{ $block }}__response">
        @foreach ($people as $item)
            @include('pages.contacts.human', $item)
        @endforeach
    </div>
</section>
