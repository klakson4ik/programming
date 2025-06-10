<div class="{{ $block }}">
    <h2 class="{{ $block->elem('header') }} c-h2">
        {!! $pageData->block_2_title !!}
    </h2>

    <div class="{{ $block->elem('content') }}">
        @foreach ($pageData->block_2_data as $item)
            <div class="{{ $block->elem('info') }}">
                <p class="{{ $block->elem('info-title') }}">
                    <b>{!! $item['title'] !!}</b>
                </p>
                <p class="{{ $block->elem('info-value') }}">
                    {{ $item['value'] }}
                </p>
                <img title="{!! $item['title'] !!}" alt="{{ __('pages.photo') }} {!! $item['title'] !!}"
                    class="{{ $block->elem('info-image') }}"
                    src="{{ asset('storage/' . $pageData->block_2_imgs[$loop->index]) }}" alt=" ">
            </div>
        @endforeach
    </div>
</div>
</div>
