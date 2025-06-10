<section class="c-container {{ $block }}" id="{{ $block }}">
    <div class="{{ $block }}__wrapper">
        <h2 class="c-purple-dark {{ $block }}__title">{{ $title }}</h2>
        <p class="c-font-subtitle {{ $block }}__subtitle">{{ $subtitle }}</p>
    </div>
    <div class="{{ $block }}__steps-wrapper">
        <ul class="{{ $block }}__steps">
            @foreach ($items as $item)
                <li class="{{ $block }}__step">
                    <div class="c-purple-light c-border-purple-light {{ $block }}__step-number">
                        {{ $item['number'] }}</div>
                    <div class="{{ $block }}__step-text">{!! $item['text'] !!}</div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
