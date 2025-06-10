<section class="{{ $block }}" id="internship-form">
    <div class=" {{ $block->elem('column')->mod('desc') }}">
        <div>
            <p class="{{ $block->elem('title') }}">
                {!! $page->block_3_title !!}
            </p>
            <p class="{{ $block->elem('text') }}">
                {!! $page->block_3_desc !!}
            </p>
        </div>
        <div class="{{ $block->elem('btn-form') }}">
            @if (locale() != '')
                {!! $renderer->renderBlock('common/button', [
                    'text' => $page->block_3_caption,
                    'icon' => 'arrow-long',
                    'url' => $page->block_3_url,
                ]) !!}
            @else
                {!! $renderer->renderBlock('common/button', [
                    'type' => 'button',
                    'text' => $page->block_3_caption,
                    'icon' => 'arrow-long',
                ]) !!}
            @endif
        </div>
    </div>
    <img class="{{ $block->elem('column')->mod('img') }}" src="/storage/{{ $page->block_3_img }}"
        alt="{{ __('pages.photo') . ' ' . $page->block_3_title }}" title="{{ $page->block_3_title }}" />
</section>
