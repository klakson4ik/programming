<div class="{{ $block }}">
    <div class="{{ $block->elem('container-slider') }}">
        <div class="{{ $block->elem('slider') }}">
            <div class="swiper-wrapper">
                @foreach ($sites as $site)
                    <div class="swiper-slide {{ $block->elem('slide') }}">
                        <div class="{{ $block->elem('container') }}">
                            <a href="/{{ locale() . 'production/sites/' . $site->action }}"
                                class="{{ $block->elem('title') }}">
                                {!! $site->title !!}
                            </a>
                            <p class="{{ $block->elem('desc') }}">
                                {!! $site->desc !!}
                            </p>
                            <a href="/{{ locale() . 'production/sites/' . $site->action }}"
                                class="{{ $block->elem('img') }}">
                                <img src="/storage/{{ $site->img }}" alt="{{ __('pages.photo') . ' ' . $site->title }}" title="{{ $site->title }}"/>
                            </a>

                            <p class="{{ $block->elem('text') }}">
                                {!! $site->text !!}
                            </p>
                        </div>
                        {!! $renderer->renderBlock('common/button', [
                            'text' => $site->btn,
                            'url' => '/' . locale() . 'production/sites/' . $site->action,
                            'icon' => 'arrow-long',
                        ]) !!}
                    </div>
                @endforeach
            </div>
            <div class="{{ $block->elem('nav') }}">
                <span class="{{ $block->elem('nav-left') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                        'left' => true,
                    ]) !!}
                </span>
                <span class="{{ $block->elem('nav-right') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                    ]) !!}
                </span>
            </div>
        </div>
    </div>
</div>
