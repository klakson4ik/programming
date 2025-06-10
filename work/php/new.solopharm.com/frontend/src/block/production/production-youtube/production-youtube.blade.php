<div class="{{ $block }} c-section-margin">
    <div class="{{ $block->elem('video') }}">
        <img class="{{ $block->elem('img') }}" src="/storage/{{ $page->poster }}" alt="{{ $page->title }}"
            title="{{ $page->title }}" />
        <div class="{{ $block->elem('play') }}">
            {!! $renderer->renderBlock('common/icon', [
                'icon' => 'watch',
            ]) !!}
        </div>
        {!! $renderer->renderBlock('/partials/popup', [
           'video' => $page->youtube,
           'videoFile' => $page->videoFile ?? false
        ]) !!}
    </div>
</div>
