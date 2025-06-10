<a href="{{ routeName() . '/' . $url }}" class="{{ $block }}">
    <div class="imgarea">
        <img src="{{ asset('storage/' . $img) }}" alt="">
        <span class="arrow">
        </span>
        <span class="hoveref">
        </span>
    </div>
    <span>{{ date('d', $date) }} {{ $months[date('n', $date)] }} {{ date('Y', $date) }}</span>

    <p>
        {{ $text }}
    </p>
</a>
