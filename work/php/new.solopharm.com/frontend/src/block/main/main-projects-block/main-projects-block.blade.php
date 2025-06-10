<div class="{{ $block }}">
    <div id="left-p-{{ $id }}" class="{{ $block->elem('item-left') }}">
        <div class="image-title" style="background-image: url('{{ asset('storage/' . $img[1]) }}')">
            <a href="{{ (isset($type) && $type == 'work')? '/career' : $url[1] }}"
                class="black-bg">
                @if (isset($type) && $type == 'work')
                    <div class="text-block-left">
                        <h2 class="c-h2">{!! __('pages.career.subtitle1') !!}</h2>
                        <div></div>
                        <br>
                        <span style="margin-left: 0%;">{!! __('pages.career.text1') !!}</span>
                    </div>
                @else
                    <img src="{{ asset('storage/' . $icon[1]) }}" alt="">
                    <div style="margin-left: 20%;
                    text-align: left;">{!! $text1[1] !!}</div>
                @endif
            </a>
        </div>
        <div onmouseover="swipeProj1('{{ $id }}');" class="text-block">


            @if (isset($type) && $type == 'work')
                <h2 class="c-h2">{!! __('pages.career.subtitle2') !!}</h2>
                <div></div>
                <span>{!! __('pages.career.text2') !!}</span>
            @else
                <h2 class="c-h2">{{ $title[1] }}</h2>
                <div></div>
                <span>{!! $text2[1] !!}</span>
            @endif
        </div>
    </div>

    <div id="right-p-{{ $id }}" class="{{ $block->elem('item-right') }}">
        <div onmouseover="swipeProj2('{{ $id }}');" class="text-block">

            @if (isset($type) && $type == 'work')
                <h2 class="c-h2">{!! __('pages.career.subtitle1') !!}</h2>
                <div style="margin-left: 22%;"></div><br>
                <span style="width: 42%; margin-left: 22%;">
                    {!! __('pages.career.text1') !!}</span>
            @else
                <h2 class="c-h2">{{ $title[0] }}</h2>
                <div style="margin-left: 23%;"></div><br>
                <span style="margin-left: 23%;
                ">{!! $text2[0] !!}</span>
            @endif


        </div>
        <div class="image-title" style="background-image: url('{{ asset('storage/' . $img[0]) }}')">
            <a href="@if (isset($type) && $type == 'work') /career/internship @else {{ $url[0] }} @endif"
                class="black-bg">
                @if (isset($type) && $type == 'work')
                    <div class="text-block-left">
                        <h2 class="c-h2">{!! __('pages.career.subtitle2') !!}</h2>
                        <div></div>
                        <br>
                        <span>{!! __('pages.career.text2') !!}</span>
                    </div>
                @else
                    <img style="margin-left: 10%;" src="{{ asset('storage/' . $icon[0]) }}" alt="">
                    <div>{!! $text1[0] !!}</div>
                @endif

            </a>
        </div>

    </div>
</div>
