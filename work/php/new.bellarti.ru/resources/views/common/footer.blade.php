<div class="b-footer" style="background-image: url('{{ $data['bg'] }}')">
    <div class="c-container">
        <div class="b-footer__row b-footer__row--top">

            <div class="b-footer__info" itemscope itemtype="http://schema.org/Organization">
                <p class="c-bold c-uppercase b-footer__info-title">
                    {!! $data['contact-us']['title'] !!}
                </p>
                <a href="tel:{{ $data['contact-us']['phone']['link'] }}" class="c-link-underline-hover b-footer__phone"
                    itemprop = "telephone">
                    {!! $data['contact-us']['phone']['text'] !!}
                </a>
                <a href="mailto:{{ $data['contact-us']['mail'] }}" class="c-link-underline-hover b-footer__mail"
                    itemprop = "email">
                    {!! $data['contact-us']['mail'] !!}
                </a>
                <p class="b-footer__address" itemscope itemprop="streetAddress">
                    {!! $data['contact-us']['office']['caption'] !!}: {!! $data['contact-us']['office']['value'] !!}
                </p>
                <p class="b-footer__address" itemscope itemprop="streetAddress">
                    {!! $data['contact-us']['production']['caption'] !!}: {!! $data['contact-us']['production']['value'] !!}
                </p>
                @if (getRouteName() !== 'feedback')
                    <a href="{{ getLink($data['contact-us']['feedback']['link']) }}"
                        class="c-bg-purple c-white c-trans-bg b-footer__feedback-btn">
                        {!! $data['contact-us']['feedback']['caption'] !!}
                    </a>
                @endif
            </div>

            <div class="c-since-lg b-footer__menu">
                @include('common.menu.root', $data)
            </div>
        </div>
        <div class="b-footer__row b-footer__row--bottom">
            <div class="b-footer__bottom-column">
                <a href="{{ $data['under']['solopharm']['link'] }}"
                    class="c-purple-dark c-link-underline b-footer__solopharm c-link-base" target="_blank">
                    {{ $data['under']['solopharm']['caption'] }}
                    <span>{!! $data['under']['solopharm']['icon'] !!} </span>
                </a>
                <a href="{{ $data['under']['youtube']['link'] }}" class="c-link-underline-hover b-footer__youtube"
                    rel="nofollow" target="_blank">
                    {{ $data['under']['youtube']['caption'] }}
                    <span>{!! $data['under']['youtube']['icon'] !!} </span>
                </a>
                <a href="{{ $data['under']['vkontakte']['link'] }}" class="c-link-underline-hover b-footer__vkontakte"
                    rel="nofollow" target="_blank">
                    <span>{!! $data['under']['vkontakte']['icon'] !!} </span>
                </a>
                <a href="{{ $data['under']['telegram']['link'] }}" class="c-link-underline-hover b-footer__telegram"
                    rel="nofollow" target="_blank">
                    <span>{!! $data['under']['telegram']['icon'] !!} </span>
                </a>
            </div>
            <div class="b-footer__bottom-column">
                <a href="{{ $data['under']['policy']['link'] }}" class="c-link-underline b-footer__policy c-link-base"
                    target="_blank">
                    {{ $data['under']['policy']['caption'] }}
                </a>
                <p class="c-purple-dark b-footer__stamp">
                    {{ $data['under']['stamp'] }}
                    </a>
            </div>
        </div>
        <div class="b-footer-techart">{!! $data['techart'] !!}</div>
    </div>
