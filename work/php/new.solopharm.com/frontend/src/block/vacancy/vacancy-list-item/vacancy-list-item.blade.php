<a class="{{ $block }}" href="{{ locale() . '/career/' . $vacancy->url_slug }}">
    <p class="{{ $block->elem('text') }}">
        {{ $vacancy->title }}
    </p>
    {!! $renderer->renderBlock('common/button', [
		'type' => 'button',
        'text' => __('pages.vacancy.respond'),
        'icon' => 'arrow-long',
    ]) !!}
</a>
