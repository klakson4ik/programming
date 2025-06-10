<div class="{{ $block }} c-container">
    <div class="{{ $block->elem('left') }}">
        <p class="c-h1">
            {!! $block2['textLeft'] !!}
        </p>
        <div class="{{ $block->elem('button') }}">
            {!! $button !!}
        </div>
    </div>
    <div class="{{ $block->elem('right') }} ">

        @foreach ($block2['textArr'] as $item)
            <div class="tabHeader @if ($loop->iteration == 1) active @endif" onclick="openTab(this);">
                <h3 class="c-h3 {{ $block->elem('right-title')}}">{{ $item['title'] }}</h3>
                <div class="c-text">
                    {{ $item['value'] }}
                </div>
            </div>
        @endforeach
    </div>


</div>
