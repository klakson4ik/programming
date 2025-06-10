<section id="{{ $block }}" class="c-container {{ $block }}">
    <div class="{{ $block }}__column">
        <h2>{!! $title !!}</h2>
        <p class="{{ $block }}__desc">
            {!! $desc !!}
        </p>
        <div class="{{ $block }}__acid">
            <p class="c-font-subtitle {{ $block }}__subtitle">{!! $subtitle !!}</p>
            <div class="{{ $block }}__items">
                @foreach ($items as $item)
                    <div class="{{ $block }}__item">
                        <div class="{{ $block }}__icon">
                            {!! $item['icon'] !!}
                        </div>
                        <p class="c-purple-dark {{ $block }}__caption">
                            {!! $item['caption'] !!}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="{{ $block }}__column">
		<div class="{{ $block }}__picture">
			@include('component.picture', $img)
		</div>
    </div>
</section>
