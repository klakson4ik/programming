<section class="{{ $block }}">
    @foreach ($laboratories as $laboratory)
        <div class="{{ $block->elem('row') }}">
            <img class="{{ $block->elem('column')->mod('img') }}" src="/storage/{{ $laboratory->img }}" alt="{{ __('pages.photo') . ' ' . strip_tags($laboratory->title) }}" title="{{ strip_tags($laboratory->title) }}">
            <div class=" {{ $block->elem('column') }}">
                <p class="{{ $block->elem('title') }}">
                    {!! $laboratory->title !!}
                </p>
                <div class="{{ $block->elem('data') }}">
                    @foreach ($laboratory->data as $item)
                        <p class="{{ $block->elem('data-item') }}"> {!! $item['value'] !!}
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</section>
