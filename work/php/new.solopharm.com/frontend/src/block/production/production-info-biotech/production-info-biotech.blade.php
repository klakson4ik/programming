<div class="{{ $block }}">
    <h2 class="c-h2 c-icon">{!! $pageData->block_2_title !!}</h2>
    <div class="text-area">
        <p class="p-border">
            {!! $pageData->block_2_tab_1 !!}
        </p>
        <ul>
            @foreach ($pageData->block_2_data_1 as $item)
                <li>{!! $item['title'] !!}</li>
            @endforeach
        </ul>
    </div>
    <div class="img-area">
        <p class="p-border">
            {!! $pageData->block_2_tab_2 !!}
        </p>
        <ul>
            @foreach ($pageData->block_2_data_2 as $item)
                <li>{!! $item['title'] !!}</li>
            @endforeach
        </ul>
    </div>

    <h2 class="c-h2">{!! $pageData->block_3_title !!}</h2>

    <div class="{{ $block->elem('slides') }}">
        @foreach ($eq as $item)
            <div>
                <img title="{!! $item->title !!}" alt="{{ __('pages.photo') }} {!! $item->title !!}"
                    src="{{ asset('storage/' . $item->img) }}" alt="">
                <p>
                    <b> {!! $item->title !!} </b>
                </p>
                <ul>
                    @foreach ($item->data as $itemLi)
                        <li><b>{!! $itemLi['title'] !!}</b>
                            <p>{!! $itemLi['value'] !!}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
