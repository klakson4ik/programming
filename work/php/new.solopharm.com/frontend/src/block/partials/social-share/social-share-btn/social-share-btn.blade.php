<div class="{{ $block }}">
    <button class="{{ $block->elem('btn') }}">
        {!! $renderer->renderBlock('common/icon', [
            'icon' => 'share',
        ]) !!}
    </button>
    <div class="{{ $block->elem('socials') }}">
        {!! $renderer->renderBlock('partials/social-share', [
            'data' => $socialShare,
        ]) !!}
    </div>
    <span>{{ __('pages.share') }}</span>
</div>
