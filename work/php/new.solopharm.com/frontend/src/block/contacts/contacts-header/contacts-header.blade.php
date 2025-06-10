<div class="{{ $block }}">
    @foreach ($data as $item)
        <span
            class="
        @if ($loop->index == 0) {{ $block->elem('city-tab')->mod('active') }}
        @else
        {{ $block->elem('city-tab') }} @endif
        "
            data-slide="{{ $loop->index }}">{{ $item->title }}</span>
    @endforeach

    
</div>
