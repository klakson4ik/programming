<div class="{{ $block }}">
    <h1 class="c-h1">{{ $header }}</h1>

    <div class="{{ $block->elem('container') }}">

        <div class="{{ $block->elem('image-content') }}" style="background-image: url({{ $img }})">
            <div>
                {!! $desc !!}
            </div>
        </div>

        <div class="{{ $block->elem('content') }}">
            <h2 class="c-h2">{!! $block1['header'] !!}</h2>

            {!! $renderer->renderBlock('partners/partners-content', [
                'mod' => $block1['mod'],
                'image' => $block1['image'],
                'statistics' => $renderer->renderBlock('partners/partners-list', [
                    'mod' => $block1['statistics']['mod'],
                    'items' => $block1['statistics']['items'],
                ]),
            ]) !!}
        </div>

        <div class="{{ $block->elem('content') }}">
            <h2 class="c-h2">{!! $block2['header'] !!}</h2>

            {!! $renderer->renderBlock('partners/partners-content', [
                'mod' => $block2['mod'],
                'content' => $block2['data']['content'],
                'image' => $block2['data']['image'],
                'statistics' => $renderer->renderBlock('partners/partners-list', [
                    'mod' => $block2['statistics']['mod'],
                    'items' => $block2['statistics']['items'],
                ]),
            ]) !!}
        </div>

        <div class="{{ $block->elem('content') }}">
            <h2 class="c-h2">{!! $block3['header'] !!}</h2>

            {!! $renderer->renderBlock('partners/partners-content', [
                'mod' => $block3['mod'],
                'content' => $block3['data']['content'],
                'image' => $block3['data']['image'],
                'statistics' => $renderer->renderBlock('partners/partners-list', [
                    'mod' => $block3['statistics']['mod'],
                    'items' => $block3['statistics']['items'],
                ]),
            ]) !!}
        </div>

        <div class="{{ $block->elem('content') }}">
            <h2 class="c-h2">{!! $block4['header'] !!}</h2>

            {!! $renderer->renderBlock('partners/partners-content', [
                'mod' => $block4['mod'],
                'content' => $block4['data']['content'],
                'image' => $block4['data']['image'],
            ]) !!}

            <div class="{{ $block->elem('links') }}">
                @foreach ($block4['links'] as $link)
                    @if ($link['url'] && $link['text'])
                        {!! $renderer->renderBlock('common/button', [
                            'type' => 'link',
                            'target' => '_blank',
                            'url' => $link['url'],
                            'text' => $link['text'],
                            'icon' => 'download',
                        ]) !!}
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>