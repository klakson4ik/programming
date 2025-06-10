<div class="{{ $block }}">
    <div class="text-area">
        {!! $pageData->block_2_subtitle !!}

        <img title="{!! strip_tags($pageData->block_2_subtitle) !!}" alt="{!! strip_tags($pageData->block_2_subtitle) !!}"
            src="{{ asset('storage/' . $pageData->block_2_img) }}">

        <p class="p-border">
            <a href="/production/release"> {!! $pageData->block_2_text_1 !!}<a>
        </p>

        {!! $pageData->block_2_desc !!}

        <ul>
            @foreach ($pageData->block_2_data as $item)
                <li>{!! $item['value'] !!}</li>
            @endforeach
        </ul>

    </div>
    <div class="img-area">
        <img title="{!! strip_tags($pageData->block_2_text_2) !!} {!! strip_tags($pageData->block_2_subtitle) !!}"
            src="{{ asset('storage/' . $pageData->block_2_img) }}">
    </div>
</div>
