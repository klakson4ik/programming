<img title="Производственные линии" alt="{{ __('pages.photo') }} Производственные линии" class="ptitleimg"
    src='@if (isset($pageData->img)) {{ asset('storage/' . $pageData->img) }} @else {{ asset('storage/' . $pageData->block_1_img) }} @endif'>

<div class="{{ $block }} c-section-margin"
    style="background-image: url('{{ isset($pageData->img) ? asset('storage/' . $pageData->img) : asset('storage/' . $pageData->block_1_img) }}');">

    <div class="content">
        @if ($_SERVER['REQUEST_URI'] == '/production/sites/biotech')
            <div class="{{ $block->elem('item')->mod('top') }}">
                <p>Проводится клиническое исследование I фазы препарата для лечения рака молочной железы</p>
            </div>
        @endif

        @if ($_SERVER['REQUEST_URI'] == '/production/sites/supplant')
            <div class="{{ $block->elem('item')->mod('top') }}">
                <p>Производственные линии</p>
            </div>
        @endif
        <div class="{{ $block->elem('data')->mod(count($pageData->block_1_data) > 6 ? 3 : 2) }}">
            @foreach ($pageData->block_1_data as $item)
                @if ($item['title'])
                    <div class="{{ $block->elem('item') }}">
                        <p class="{{ $block->elem('item-title') }}">{!! $item['title'] !!}</p>
                        <p>{!! $item['value'] !!}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>
