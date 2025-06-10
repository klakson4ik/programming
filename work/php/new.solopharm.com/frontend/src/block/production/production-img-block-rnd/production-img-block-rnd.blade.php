<div class="{{ $block }} c-section-margin"
    style="background-image: url({{ asset('storage/' . "images/rnd1.webp") }})">
    <div class="{{ $block->elem('content') }}">
        @foreach ($pageData->block_1_data as $item)
            @if ($item['title'] == 0)
                <div class="{{ $block->elem('cell')->mod('none') }}"></div>
            @else
                <div class="{{ $block->elem('cell') }}">
                    <p class="{{ $block->elem('zg') }}">{!! $item['title'] !!}</p>
                    <p class="{{ $block->elem('text')}}">{!! $item['value'] !!}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
