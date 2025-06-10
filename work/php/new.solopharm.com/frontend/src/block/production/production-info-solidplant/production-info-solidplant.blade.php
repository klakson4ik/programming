<div class="{{ $block }}">


    <div class="{{ $block->elem('slides') }}">
        @foreach ($sysData as $item)
            <div>
                <img title="{!! $item->title !!}" alt="{{ __('pages.photo') }} {!! $item->title !!}"
                    src=" {{ asset('storage/' . $item->img) }} " alt="">
                <p>
                    <b> {!! $item->title !!} </b> {!! $item->desc !!}
                </p>
            </div>
        @endforeach
    </div>
    <div class="text-area">
        <h2 class="c-h2">{!! $pageData->block_3_title !!}</h2>
        {!! $pageData->block_3_desc !!}
        <img title="{!! $pageData->block_3_title !!}" alt="{{ __('pages.photo') }}{!! $pageData->block_3_title !!}"
            src="{{ asset('storage/' . $pageData->block_3_img) }}">
        <div class="info-cols">
            <div class="left">

                @foreach ($pageData->block_3_data_1 as $item)
                    <div class="left-nums">
                        <p class="c-h1">{!! $item['title'] !!}</p>
                        <b>{!! $item['value'] !!}</b>
                    </div>
                @endforeach
            </div>
            <div class="right">
                <p class="p-border">
                  {!! $pageData->block_3_text !!}
                </p>
                <ul>

                    @foreach ($pageData->block_3_data_2 as $item)
                        <li>{!! $item['title'] !!}</li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    <div class="img-area">
        <img title="{!! $pageData->block_3_title !!}" alt="{{ __('pages.photo') }}{!! $pageData->block_3_title !!}"
            src="{{ asset('storage/' . $pageData->block_3_img) }}">
    </div>
</div>
