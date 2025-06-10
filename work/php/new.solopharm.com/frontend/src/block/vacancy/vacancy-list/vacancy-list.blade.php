<div class="{{ $block->elem('additional')->mod('active') }}" data-city="{{ $city ?? 'Санкт-Петербург' }}">
    @foreach ($vacancies as $key => $section)
        <div class="{{ $block->elem('item') }}">
            <div class="{{ $block->elem('item-section') }}" data-id="{{ $key }}">
                <p>{{ $key }}&nbsp({{ count($section) }})
                <div class="{{ $block->elem('icon') }}">
                    <div class="{{ $block->elem('icon-container') }}">
                        <div class="{{ $block->elem('icon-first') }}">
                        </div>
                        <div class="{{ $block->elem('icon-last') }}">
                        </div>
                    </div>
                </div>
            </div>
            @if (count($section) > 0)
                <div class="{{ $block->elem('item-sub') }}">
                    @foreach ($section as $vacancy)
                        {!! $renderer->renderBlock('vacancy/vacancy-list-item', ['vacancy' => $vacancy]) !!}
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
