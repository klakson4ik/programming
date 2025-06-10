<a href="{{ routeName() . '/' . $url }}" class="{{ $block }}">
    <div class="{{ $block->elem('image') }}" style="background-image: url('{{ asset('storage/' . $img) }}');">
    </div>
    <p>
        {{ $text }}
    </p>

    <div class="arrow">
    </div>
    <span class="hoveref">
    </span>
</a>
