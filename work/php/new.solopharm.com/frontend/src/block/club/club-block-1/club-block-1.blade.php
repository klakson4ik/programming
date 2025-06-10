<div class="{{ $block }}">
    <p class="{{ $block->elem('desc') }}"> {!! $page->desc !!}</p>
    <div class="{{ $block->elem('video') }}">
        <img class="{{ $block->elem('img') }}" src="/storage/{{ $page->img }}" alt="{{ $page->title }}"
            title="{{ $page->title }}" />
        <div class="{{ $block->elem('play') }}">
            {!! $renderer->renderBlock('common/icon', [
                'icon' => 'watch',
            ]) !!}
        </div>
        {!! $renderer->renderBlock('/partials/popup', [
           'video' => $page->youtube
        ]) !!}
    </div>
</div>
