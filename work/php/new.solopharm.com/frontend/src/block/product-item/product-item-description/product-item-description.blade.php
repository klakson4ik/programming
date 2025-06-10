@php
    $imgMeta = __('pages.product.img.alt-start') . ' ' . $product->title . ' ' . $currentTrade->form . ' - ' . __('pages.product.img.alt-end');
@endphp
<div class="{{ $block }}">
    <div class="{{ $block->elem('img') }}">
        @if (
            $product->instruction || $product->site || $product->IQ_provision || $product->youtube ||
            $currentTrade->instruction || $currentTrade->site || $currentTrade->IQ_provision || $currentTrade->youtube
        )
            <div class="{{ $block->elem('action') }}">
                @if ($currentTrade->youtube)
                    <a class="{{ $block->elem('action-link')->mod('youtube') }}"
                        data-title="{{ __('pages.product.tooltip.youtube') }}">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'youtube',
                        ]) !!}
						@if($product->tube_type === 'rutube')
							{!! $renderer->renderBlock('/partials/popup', [
								'video' => $product->rutube,
								'videoType' => $product->tube_type
							]) !!}
						@else
							{!! $renderer->renderBlock('/partials/popup', [
								'video' => $product->youtube,
								'videoType' => $product->tube_type
							]) !!}
						@endif
                    </a>
                @elseif ($product->youtube)
                    <a class="{{ $block->elem('action-link')->mod('youtube') }}"
                        data-title="{{ __('pages.product.tooltip.youtube') }}">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'youtube',
                        ]) !!}
						@if($product->tube_type === 'rutube')
							{!! $renderer->renderBlock('/partials/popup', [
								'video' => $product->rutube,
								'videoType' => $product->tube_type
							]) !!}
						@else
							{!! $renderer->renderBlock('/partials/popup', [
								'video' => $product->youtube,
								'videoType' => $product->tube_type
							]) !!}
						@endif
                    </a>
                @endif
                @if ($currentTrade->site)
                    <a class="{{ $block->elem('action-link') }}" data-title="{{ __('pages.product.tooltip.site') }}"
                        href="{{ href($currentTrade->site) }}" target="_blank">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'site',
                        ]) !!}
                    </a>
                @elseif ($product->site)
                    <a class="{{ $block->elem('action-link') }}" data-title="{{ __('pages.product.tooltip.site') }}"
                        href="{{ href($product->site) }}" target="_blank">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'site',
                        ]) !!}
                    </a>
                @endif
                @if($currentTrade->instruction)
                    <a class="{{ $block->elem('action-link') }}"
                        data-title="{{ __('pages.product.tooltip.instruction') }}"
                        href="/storage/{{ $currentTrade->instruction }}" target="_blank">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'instruction',
                        ]) !!}
                    </a>
                @elseif ($product->instruction)
                    <a class="{{ $block->elem('action-link') }}"
                        data-title="{{ __('pages.product.tooltip.instruction') }}"
                        href="/storage/{{ $product->instruction }}" target="_blank">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'instruction',
                        ]) !!}
                    </a>
                @endif
                @if ($currentTrade->IQ_provision)
                    <a class="{{ $block->elem('action-link') }}" data-title="{{ __('pages.product.tooltip.iq') }}"
                        href="{{ href($currentTrade->IQ_provision) }}" target="_blank">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'iq',
                        ]) !!}
                    </a>
                @elseif ($product->IQ_provision)
                    <a class="{{ $block->elem('action-link') }}" data-title="{{ __('pages.product.tooltip.iq') }}"
                        href="{{ href($product->IQ_provision) }}" target="_blank">
                        {!! $renderer->renderBlock('common/icon', [
                            'sprite' => 'product',
                            'icon' => 'iq',
                        ]) !!}
                    </a>
                @endif
            </div>
        @endif
        @if($currentTrade->vital || $currentTrade->soon)
            <div class="{{ $block->elem('chars') }}">
                @if($currentTrade->soon)
                    <p class="{{ $block->elem('char')->mod('soon') }}">{{ __('pages.soon') }}</p>
                @endif
                @if($currentTrade->vital)
                    <p class="{{ $block->elem('char')->mod('vital') }}" data-descr="{{ __('pages.vital-description') }}">{{ __('pages.vital') }}{!! file_get_contents('images/icons/exclamate.svg') !!}</p>
                @endif
            </div>
        @endif
        <img src="{{ $currentTrade->img ? '/storage/' . $currentTrade->img : '/images/s-empty-detail.webp' }}" alt="{{ __('pages.photo') . ' ' .$imgMeta }}" title="{{ $imgMeta }}">
        @if ($trades->count() > 3)
            <div class="{{ $block->elem('container-slider') }}">
                <div class="{{ $block->elem('slider') }}">
                    <div class="swiper-wrapper">
                        @foreach ($trades as $item)
                            <a class="{{ $block->elem('slide')->mod($currentTrade->id === $item->id ? 'active' : '') }} swiper-slide"
                                href="/{{ locale() . routeName() . '/' . $product->url_slug . '/' . $item->url_slug }}">
                                <img class="{{ $block->elem('slide-img') }}" src="{{ $item->img ? '/storage/' . $item->img : '/images/s-empty-detail.webp' }}"
                                    alt="{{ __('pages.photo') . ' ' . $item->form }}" title="{{ $item->form }}" />
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="{{ $block->elem('nav') }}">
                    <button class="{{ $block->elem('nav-left') }}">
                        {!! $renderer->renderBlock('common/icon', [
                            'icon' => 'arrow-short',
                        ]) !!}
                    </button>
                    <button class="{{ $block->elem('nav-right') }}">
                        {!! $renderer->renderBlock('common/icon', [
                            'icon' => 'arrow-short',
                        ]) !!}
                    </button>
                </div>
            </div>
        @elseif($trades->count() > 1)
            <div class="{{ $block->elem('container-thumbs') }}">
                <div class="{{ $block->elem('thumbs') }}">
                    @foreach ($trades as $item)
                        <a class="{{ $block->elem('thumb')->mod($currentTrade->id === $item->id ? 'active' : '') }}"
                            href="/{{ locale() . routeName() . '/' . $product->url_slug . '/' . $item->url_slug }}">
                            <img class="{{ $block->elem('thumb-img') }}" src="{{ $item->img ? '/storage/' . $item->img : '/images/s-empty-detail.webp' }}"
                                alt="{{ __('pages.photo') . ' ' . $item->form }}" title="{{ $item->form }}" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <div class="{{ $block->elem('share') }}">
        {!! $renderer->renderBlock('partials/social-share/social-share-btn', [
            'socialShare' => $socialShare,
        ]) !!}
    </div>
    @if ($currentTrade->indications || $product->indications)
        <div class="{{ $block->elem('desc') }}">
            <p class="{{ $block->elem('desc-title') }}">

                @if($product->category == 'dietary_supplements' || !$product->category)
                    {!! __('pages.product.scope') !!}
                @else
                    {!! __('pages.product.indications') !!}
                @endif
            </p>
            <p class="{{ $block->elem('desc-text') }}">
                {!! $currentTrade->indications ?? $product->indications !!}
            </p>
        </div>
    @endif
</div>
