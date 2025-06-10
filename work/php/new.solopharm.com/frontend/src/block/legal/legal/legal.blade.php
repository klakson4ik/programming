<div class="{{ $block }}">
    <h1 class="c-h1">{{ $page->title }}</h1>
    @isset($sites)
        <section class="b-legal__row">
            @foreach ($sites as $site)
                <h2 class="c-h2">{{ $site->title }}</h2>
                @isset($site->legals)
                    <div class="b-legal__legals">
                        @foreach ($site->legals as $legal)
                            {!! $renderer->renderBlock('legal/legal-item', [
                                'legal' => $legal,
                            ]) !!}
                        @endforeach
                    </div>
                @endisset
            @endforeach
        </section>
    @endisset
</div>