<div class="{{ $block }}">
    <h1 class="c-h1">{{ $gallery->title }}</h1>
    @isset($gallery)
        {!! $renderer->renderBlock('gallery/gallery-slider', [
            'gallery' => $gallery->galleries,
            'title' => $gallery->title,
        ]) !!}
    @endisset
    @if ($gallery->btn)
        {!! $renderer->renderBlock('common/button', [
            'icon' => 'arrow-long',
            'text' => $gallery->btn,
            'url' => $gallery->action,
        ]) !!}
    @endif
</div>