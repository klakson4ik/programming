<div class="{{ $block }}">
    @if ($technologies->count() > 1)
        <div class="{{ $block->elem('container-slider') }}">
            <div class="{{ $block->elem('slider') }}">
                @foreach ($technologies as $key=>$technology)
                    <button class="{{ $block->elem('slide')->mod($key == 0 ? 'active' : '') }}" data-technology="{{ $technology->id }}" data-id="{{ $key }}">
                        {!! file_get_contents('storage/' . $technology->svg) !!}
                        <p class="{{ $block->elem('slide-text') }}">
                            {{ $technology->short_title }}
                        </p>
                    </button>
                @endforeach
            </div>

        </div>
        <div class="{{ $block->elem('nav') }}">
            <div class="{{ $block->elem('nav-action') }}">
                <span class="{{ $block->elem('nav-left') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button',
                        'left' => true,
                    ]) !!}
                </span>
                <span class="{{ $block->elem('nav-right') }}">
                    {!! $renderer->renderBlock('common/arrow', [
                        'type' => 'button'
                    ]) !!}
                </span>
            </div>
        </div>
    @endif
</div>
