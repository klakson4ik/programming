<div class="{{ $block }}">
    <div class="{{ $block->elem('container') }}">
        <div class="{{ $block->elem('slider') }}">
            <div class="swiper-wrapper">
                @foreach ($choiceFilters as $name => $item)
                    @if ($name === 'direction_id')
                        @foreach ($item as $id)
                            @foreach ($directions as $direction)
                                @if ($direction->id == $id)
                                    <div class="{{ $block->elem('tag') }} swiper-slide">
                                        <span>{{ $direction->name }}</span>
                                        <button class="{{ $block->elem('del') }}"
                                            name="{{ $direction->url_slug }}">{!! $renderer->renderBlock('common/icon', [
                                                'icon' => 'close',
                                            ]) !!}</button>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <div class="{{ $block->elem('tag') }} swiper-slide">
                            <span>{{ __('pages.' . $name) }}</span>
                            <button class="{{ $block->elem('del') }}"
                                name="{{ $name }}">{!! $renderer->renderBlock('common/icon', [
                                    'icon' => 'close',
                                ]) !!}</button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
