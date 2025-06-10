<div class="{{ $block }}">


    {!! $renderer->renderBlock('common/button', [
        'type' => 'link',
        'url' => $url,
        'text' => $text,
        'icon' => 'arrow-long',
    ]) !!}

</div>
