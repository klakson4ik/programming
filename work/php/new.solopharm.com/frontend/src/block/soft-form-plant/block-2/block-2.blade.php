<div class="{{ $block }}">
    <h2 class="c-h2">{!! $title !!}</h2>
    <div class="{{ $block->elem('row') }}">
        <div class="{{ $block->elem('column') }}">
            @if (count($items) > 0)
                <div class="{{ $block->elem('items') }}">
                    @foreach ($items as $item)
                        <p class="{{ $block->elem('item') }}">{!! $item['value'] !!}</p>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="{{ $block->elem('column') }}">
            <img title="Производственные линии" alt="{{ __('pages.photo') }} Производственные линии"
                src="{{ asset('storage/' . $img) }}">
        </div>
    </div>
</div>
