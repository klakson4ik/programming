<div class="{{ $block }}">
    <div class="{{ $block->elem('header') }}">
        <h2 class="c-h2 {{ $block->elem('title') }}">
            {!! $page->control_quality_title !!}
        </h2>
        <img src="{{ asset('storage/' . $page->control_quality_title_svg) }}" />
    </div>
    <div class="{{ $block->elem('row') }}">
        <div class="{{ $block->elem('column') }}">
            @if (count($page->control_quality_data) > 0)
                @foreach ($page->control_quality_data as $item)
                    <p class="{{ $block->elem('item') }}">{!! $item['value'] !!}</p>
                @endforeach
            @endif
        </div>
        <div class="{{ $block->elem('column') }}">
            <p class="{{ $block->elem('subtitle') }}">
                {!! $page->control_quality_subtitle !!}
            </p>
            <img title="Контроль качества" alt="Контроль качества"
                src="{{ asset('storage/' . $page->control_quality_img) }}">
        </div>
    </div>
</div>
