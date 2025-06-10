<div class="{{ $block }}">
    <h1 class="c-h1">{{ __('pages.contacts.title') }}</h1>

    {!! $renderer->renderBlock('contacts/contacts-header', [
        'data' => $data,
    ]) !!}
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach ($data as $item)
                <div class="swiper-slide">

                    <div class="col">
                        @foreach ($item->data as $itemCon)
                            <div class="{{ $block->elem('item-cont') }}">
                                <span class="header-item">
                                    {{ $itemCon['title'] }}
                                    <img src="/images/icons/arrow-short.svg" alt="">
                                </span>
                                <div class="text-item">
                                    <p>
                                        {{ $itemCon['contact'] }}
                                    </p>
                                    <span>
                                        <a href="mailto:{{ $itemCon['email'] }}">
                                            {{ $itemCon['email'] }}
                                        </a>
                                    </span>
                                    @if (isset($itemCon['more']))
                                        <div class="{{ $block->elem('item-cont-more') }}">
                                            {!! $itemCon['more'] !!}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($loop->index == ceil($loop->count / 2 - 1))
                    </div>
                    <div class="col rightcol">
            @endif
            @endforeach
        </div>
        @if ($loop->index < 1)
            <img id="cont-img" src="{{ asset('storage/images/contphoto.png') }}" alt="">
        @endif


        <div class="{{ $block->elem('pdf_cols') }}">
            @foreach ($local as $itemLoc)
                @if ($itemLoc->contact_id == $item['id'])
                    <div class="cont-cols">
                        @if ($itemLoc->title != '' || $itemLoc->title != null)
                            <p><b>{{ $itemLoc->title }}:</b></p>
                        @endif
                        <p>
                            {!! $itemLoc->desc !!}
                        </p>
                        {!! $renderer->renderBlock('common/button', [
                            'target' => '_blank',
                            'type' => 'link',
                            'url' => '/storage/' . $itemLoc->file,
                            'text' => $itemLoc->btn,
                            'icon' => 'download',
                        ]) !!}

                    </div>
                @endif
            @endforeach

        </div>

        <div id="map{{ $loop->index }}"
            data-points="[@foreach ($local as $itemLoc)  @if ($itemLoc->contact_id == $item['id']) {{ $itemLoc }} , @endif @endforeach  {}]"
            class="ymap"></div>
    </div>
    @endforeach
</div>
</div>
</div>
