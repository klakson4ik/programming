<div class="one-blog__wrapper" itemscope itemtype="http://schema.org/Article">
    @if (count($data) > 1)
        @foreach ($data as $el)
            <div class="c-indent-bottom" itemscope itemprop="articleBody">
                @isset($el['full_img'])
                    <div class="one-blog__img-wrapper">
                        <img src="{!! $el['full_img'] !!}" alt="" itemprop="image">
                    </div>
                @endisset

                <div class="one-blog__desc one-blog__desc--reduced">{!! $el['description'] !!}</div>

                <div class="one-blog__info">
                    <div class="one-blog__info-left">
                        <p class="c-bg-purple c-white one-blog__info-date" itemprop="datePublished">
                            {!! $el['date'] !!}</p>
                        <p class="one-blog__info-time">{!! $el['time'] !!}</p>
                    </div>
                    <p class="one-blog__info-name">{!! $el['city']['name'] !!}</p>
                </div>
                @if (isset($el[0]) && isset($el[0]['link']) && $el[0]['link'] != '')
                    <a href="{{ $el['link'] }}" target="_blank" title="{{ $title }}" alt="{{ $title }}"
                        rel="nofollow" class="c-link one-blog__link">{{ $title }}
                        {!! getCommonIcon('arrow-more') !!}
                    </a>
                @endif
            </div>
        @endforeach
    @else
        <div class="c-indent-bottom" itemscope itemprop="articleBody">
            @isset($data[0]['full_img'])
                <div class="one-blog__img-wrapper">
                    <img src="{!! $data[0]['full_img'] !!}" alt="" itemprop="image">
                </div>
            @endisset

            @if (count($data) > 0)
                <div class="one-blog__desc">{!! $data[0]['description'] !!}</div>
                <div class="one-blog__info">
                    <div class="one-blog__info-left">
                        <p class="c-bg-purple c-white one-blog__info-date" itemprop="datePublished">
                            {!! $data[0]['date'] !!}
                        </p>
                        <p class="one-blog__info-time">{!! $data[0]['time'] !!}</p>
                    </div>
                    <p class="one-blog__info-name">{!! $data[0]['city']['name'] !!}</p>
                </div>

                @if ($data[0]['link'] != '' && $data[0]['link'] != null)
                    <a href="{!! $data[0]['link'] !!}" target="_blank" title="{{ $title }}"
                        alt="{{ $title }}" class="c-link one-blog__link" rel="nofollow">{{ $title }}
                        {!! getCommonIcon('arrow-more') !!}
                    </a>
                @endif

                @include('component.social-share')
            @endif
        </div>
    @endif
</div>
