<div class="{{ $block }}">
    <div class="{{ $block->elem('row') }}">
        <div class="{{ $block->elem('column')->mod('left') }}">
            @if (count($items) > 0)
                <h3 class="c-h3 {{ $block->elem('subtitle') }}">
					{!! $subtitle !!}
				</h3>
                <div class="{{ $block->elem('items') }}">
                    <p class="p-border">
                        {!! $items[0]['value'] !!}
                    </p>
                    <ul>
                        @for ($i = 1; $i < count($items); $i++)
                            <li>{!! $items[$i]['value'] !!}</li>
                        @endfor
                    </ul>
                </div>
            @endif
        </div>
        <div class="{{ $block->elem('column')->mod('right') }}">
            <img title="Производственные линии" alt="{{ __('pages.photo') }} Производственные линии"
                src="{{ asset('storage/' . $img) }}">
        </div>
    </div>
</div>
