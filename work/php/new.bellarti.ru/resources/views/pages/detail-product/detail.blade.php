<section class="c-container {{ $block }}" id="{{ $block }}">
    <div class="{{ $block }}__main">
        <h2 class="c-h1 c-purple-dark {{ $block }}__title">{{ $product->name }}</h2>
        <p class="c-purple-dark c-uppercase c-font-subtitle {{ $block }}__subtitle">{{ $product->title }}</p>
        <div class="{{ $block }}__content">
            <div class="{{ $block }}__image-wrapper">
                @if (!empty($offer->images))
                    <img class="{{ $block }}__image" src="{{ $offer->images }}"
                        alt="{{ $product->name }}">
                @else
                    <img class="{{ $block }}__image" src="{{ $product->images }}"
                        alt="{{ $product->name }}">
                @endif
                <div class="{{ $block }}__image-minimaze-wrapper">
                    @include('component.slider.default', $slider)
                </div>
                @if (!empty($product->file) && !is_null($product->file[0]['value']))
                    <div class="{{ $block }}__files-wrapper">
                        @foreach ($product->file as $key => $element)
                            <a href="{{ getLink(getStorageFile($element['value'])) }}" target="_blank"
                                class="c-purple-dark {{ $block }}__files">
                                {!! $main['docs'] !!}
                                <span class="{{ $block }}__files-name">{{ $element['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="{{ $block }}__description">
                <div class="{{ $block }}__offer-description">
                    {!! $offer->description ?? $product->description !!}
                </div>


                <nav class="{{ $block }}__nav">
                    <ul class="{{ $block }}__offers-list">
                        @foreach ($offers as $element)
                            <li
                                class="c-border-black {{ $block }}__offer-item {{ request()->is('product/' . $element['parentElement'] . '/' . $element['url']) ? 'c-border-purple-dark inactive' : '' }}">
                                <a class="c-black {{ $block }}__offer-link {{ request()->is('product/' . $element['parentElement'] . '/' . $element['url']) ? 'c-purple-dark inactive' : '' }}"
                                    href="/product/{{ $element['parentElement'] }}/{{ $element['url'] }}">{{ $element['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="{{ $block }}__detail-main">
                    @if (isset($offer))
                        {{-- Детали торгового предложения --}}
                        <div class="{{ $block }}__detail-wrapper">
                            <p
                                class="c-purple-dark c-uppercase {{ $block }}__detail {{ $block }}__detail">
                                Состав:
                                {!! getCommonIcon('arrow-45') !!}</p>
                            <div class="hidden c-trans {{ $block }}__detail-content"> {!! $offer->structure ?? $product->structure !!}
                            </div>
                        </div>
                        <div class="{{ $block }}__detail-wrapper">
                            <p class="{{ $block }}__detail c-purple-dark c-uppercase">Показания:
                                {!! getCommonIcon('arrow-45') !!}</p>
                            <div class="hidden c-trans {{ $block }}__detail-content">{!! $offer->indications ?? $product->indications !!}
                            </div>
                        </div>
                        <div class="{{ $block }}__detail-wrapper">
                            <p class="c-purple-dark c-uppercase {{ $block }}__detail">Курс:
                                {!! getCommonIcon('arrow-45') !!}
                            </p>
                            <div class="hidden c-trans {{ $block }}__detail-content"> {!! $offer->course ?? $product->course !!}
                            </div>
                        </div>
                    @else
                        {{-- Детали продукта --}}
                        <div class="{{ $block }}__detail-wrapper">
                            <p class="{{ $block }}__detail c-purple-dark c-uppercase">Состав:
                                {!! getCommonIcon('arrow-45') !!}</p>
                            <div class="{{ $block }}__detail-content hidden c-trans">
                                {{ $product->structure }}</div>
                        </div>
                        <div class="{{ $block }}__detail-wrapper">
                            <p class="{{ $block }}__detail c-purple-dark c-uppercase">Показания:
                                {!! getCommonIcon('arrow-45') !!}</p>
                            <div class="{{ $block }}__detail-content hidden c-trans">
                                {{ $product->indications }}</div>
                        </div>
                        <div class="{{ $block }}__detail-wrapper">
                            <p class="{{ $block }}__detail c-purple-dark c-uppercase">Курс:
                                {!! getCommonIcon('arrow-45') !!}
                            </p>
                            <div class="{{ $block }}__detail-content hidden c-trans">{{ $product->course }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
