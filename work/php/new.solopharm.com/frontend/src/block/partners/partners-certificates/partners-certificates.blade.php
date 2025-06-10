<div class="{{ $block }}">
    <h1 class="c-h1">{{ $header }}</h1>

    <div class="{{ $block->elem('container') }}">
        <div class="{{ $block->elem('certificates') }}">
            @foreach ($certificates as $key => $certificate)
                {!! $renderer->renderBlock('partners/certificate', [
                    'item' => $certificate,
                    'reverse' => $key % 2 == 1
                ]) !!}
            @endforeach
        </div>
    </div>
</div>