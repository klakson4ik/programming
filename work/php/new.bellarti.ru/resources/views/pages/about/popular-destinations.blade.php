<section class="{{ $block }}" id="{{ $block }}" style="background-image: url('{{ $background }}')">
    <div class="c-container {{ $block }}__wrapper">
        <h3 class="{{ $block }}__title">{{ $title }}</h3>

        <div class="{{ $block }}__info">
            @foreach ($items as $item)
                <p class="c-font-subtitle {{ $block }}__info-desc">{!! $item['icon'] !!}<span>{{ $item['text'] }}<span> </p>
            @endforeach
        </div>
    </div>
</section>
