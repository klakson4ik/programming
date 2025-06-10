<section class="{{ $block }}">
    <p class="{{ $block->elem('column')->mod('desc') }}"> {!! $page->desc !!}</p>
    <img class="{{ $block->elem('column')->mod('img') }}" src="/storage/{{ $page->img }}" alt="{{ __('pages.photo') . ' ' . $page->title }}"

        title="{{ $page->title }}" />
</section>
