<div class="one-blog__wrapper">
    @if (count($cards['future']) > 0)
        @foreach ($cards['future'] as $el)
            <div class="c-indent-bottom">
                @isset($el['full_img'])
                    <div class="one-blog__img-wrapper">
                        <img src="/storage/{!! $el['full_img'] !!}" alt="{{ $el['title'] }}" title="{{ $el['title'] }}">
                    </div>
                @endisset
                <div class="one-blog__desc">{!! $el['description'] !!}</div>

                <div class="one-blog__info">
                    <div class="one-blog__info-left">
                        <p class="c-bg-purple c-white one-blog__info-date">{!! $el['date'] !!}</p>
                        <p class="one-blog__info-time">{!! $el['time'] !!}</p>
                    </div>
                    <p class="one-blog__info-name">{!! $el['city']['name'] !!}</p>
                </div>
                @if ($el['link'] != null && $el['link'] != '')
                    <a href="{{ $el['link'] }}" target="_blank" rel="nofollow" class="c-link one-blog__link">Ссылка на
                        регистрацию
                        {!! getCommonIcon('arrow-more') !!}
                    </a>
                @endif
            </div>
        @endforeach
    @elseif (count($cards['past']) > 0)
        @foreach ($cards['past'] as $el)
            <div class="c-indent-bottom">
                @isset($el['full_img'])
                    <div class="one-blog__img-wrapper">
                        <img src="/storage/{!! $el['full_img'] !!}" alt="{{ $el['title'] }}" title="{{ $el['title'] }}">
                    </div>
                @endisset

                <div class="one-blog__desc">{!! $el['description'] !!}</div>

                <div class="one-blog__info">
                    <div class="one-blog__info-left">
                        <p class="c-bg-purple c-white one-blog__info-date">{!! $el['date'] !!}</p>
                        <p class="one-blog__info-time">{!! $el['time'] !!}</p>
                    </div>
                    <p class="one-blog__info-name">{!! $el['city']['name'] !!}</p>
                </div>
                @if ($el['link'] != '' && $el['link'] != null)
                    <a href=" {{ $el['link'] }}" target="_blank" rel="nofollow" class="c-link one-blog__link">Ссылка
                        на регистрацию
                        {!! getCommonIcon('arrow-more') !!}
                    </a>
                @endif
            </div>
        @endforeach
    @endif
</div>
