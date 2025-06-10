<div class="{{ $block }} c-section-margin">
    <h2 class="{{ $block->elem('header') }} c-h2">
        {!! $pageData->block_2_title !!}
    </h2>

    <div class="{{ $block->elem('content') }}">
        <div class="{{ $block->elem('control') }}">
            <div class="{{ $block->elem('navigate') }}">
                <div class="{{ $block->elem('arrow')->mod('left') }}">
                    <svg width="13" height="50" viewBox="0 0 13 50" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.53101 48.3975L6.53101 3.37305" stroke="#FD7D5A" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M11.3975 6.57776L6.40582 1.58606L1.41412 6.57776" stroke="#FD7D5A" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <div class="{{ $block->elem('arrow')->mod('right') }}">
                    <svg width="13" height="50" viewBox="0 0 13 50" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.53101 48.3975L6.53101 3.37305" stroke="#FD7D5A" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M11.3975 6.57776L6.40582 1.58606L1.41412 6.57776" stroke="#FD7D5A" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>
            <div class="{{ $block->elem('pagination') }}">
            </div>
        </div>

        <div class="{{ $block->elem('slider') }}">
            <div class="swiper-wrapper">
                @foreach ($achievement as $item)
                    <div class="swiper-slide swiper-no-swiping">
                        {!! $item['text'] !!}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="{{ $block->elem('btn') }}">
            {!! $renderer->renderBlock('common/button', [
                'type' => 'link',
                'url' => '/storage/' . $pageData->block_2_btn_link,
                'text' => $pageData->block_2_btn_caption,
                'icon' => 'arrow-long',
                'target' => '_blank',
            ]) !!}
        </div>
    </div>
    <img title="{!! strip_tags($pageData->block_2_title) !!}" alt="{{ __('pages.photo') }} {!! strip_tags($pageData->block_2_title) !!}"
        class="{{ $block->elem('image') }}" src="/images/val.jpg" alt="">
</div>
