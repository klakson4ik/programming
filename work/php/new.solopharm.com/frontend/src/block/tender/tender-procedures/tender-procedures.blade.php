<section class="{{ $block }}">
    <div class=" {{ $block->elem('column')->mod('frame') }}">
        <iframe
            src="https://bidzaar.com/publicprofile/index/a0ccb1ea-c541-4161-86e3-a6be5d5e8a5a?embedded=true&type=page"
            style="border: none;" width="100%" height="680"></iframe>
    </div>
    <img class="{{ $block->elem('column')->mod('img') }}" src="/storage/{{ $page->img }}" alt="{{ __('pages.photo') . ' ' . $page->subtitle }}"
        title="{{ $page->subtitle }}" />
</section>
