<div class="{{ $block }}">

    <div class="text-area">
        <img src="/images/icons/arrow-down-cir.svg" alt="">
        <h2 class="c-h2">
            {!! $pageData->block_2_title !!}
        </h2>
        <img src="/images/icons/gmpi.png" alt="">
        {!! $pageData->block_2_text !!}
    </div>

    <div class="img-area">
        <img title="{!! $pageData->block_2_title !!}" alt="{{ __('pages.photo') }} {!! $pageData->block_2_title !!}"
            src="{{ asset('storage/' . $pageData->block_2_img) }}" alt="">
    </div>

    <h2 class="c-h2">
        {!! $pageData->block_3_title !!}
    </h2>

    <div class="left">
        <p class="p-border">
            {{ $supdSys[0]->title }}
        </p>
        <ul>
            @foreach ($supdSys[0]->data as $item)
                <li>{{ $item['value'] }}</li>
            @endforeach
        </ul>
    </div>

    <div class="right">
        <p class="p-border">
            {{ $supdSys[1]->title }}
        </p>
        <ul>
            @foreach ($supdSys[1]->data as $item)
                <li>{{ $item['value'] }}</li>
            @endforeach
        </ul>
    </div>
</div>
