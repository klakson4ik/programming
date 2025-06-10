<div class="{{ $block }} c-section-margin">
    {!! $pageData->text !!}

    <div class="{{ $block->elem('swiper-area') }}">
        <div class="{{ $block->elem('nav') }}">
            <div class="{{ $block->elem('nav-action') }}">
                <span class="{{ $block->elem('nav-left') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                        'left' => true,
                    ]) !!}
                </span>
                <span class="{{ $block->elem('nav-right') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                    ]) !!}
                </span>
            </div>
        </div>
        <div class="slider-eq">
            <div class="header">
                <h2 class="c-h2">{!! $eqP[0]->title !!}</h2>
                <h2 class="c-h2">{!! $eqP[1]->title !!}</h2>
            </div>

            <div class="swiper-wrapper">
                @foreach ($eqP as $item)
                    <div class="swiper-slide" style="background-image: url('{{ asset('storage/' . $item->img) }}')">
                        <div class="content">
                            @foreach ($item['data'] as $item)
                                <div
                                    @if (!$item['title']) class="cell mhidden" style="border:none; margin-top: 0;" @else class="cell" @endif>
                                    <h2 class="c-h2 text">{{ $item['title'] }}</h2>
                                    <p>
                                        {{ $item['value'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
