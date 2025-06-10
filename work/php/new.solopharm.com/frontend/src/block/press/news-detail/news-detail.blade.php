<div class="{{ $block }} c-container">
    <meta itemprop="name" content="Solopharm">
    <h1 itemprop="headline" class=" {{ $block->elem('header') }} c-h1">{!! $title !!}</h1>
    <meta itemprop="description" content="{!! strip_tags(mb_strimwidth($text, 0, 200, '...')) !!}">


    <span itemprop="datePublished" content="{{ date('Y-m-d H:i:s', $date) }}"
        class="{{ $block->elem('date') }}">{{ date('d', $date) }}
        @if (locale() == 'en/')
            {{ date('F', $date) }}
        @else
            {{ $months[date('n', $date)] }}
        @endif

        {{ date('Y', $date) }}
    </span>

    <div itemprop="articleBody" class="{{ $block->elem('text') }}">
        {!! $text !!}
    </div>

    @if (isset($tag))
        <div class="{{ $block->elem('tag') }}">
            <span> Источник: <a itemprop="url" href="{{ $tag_url }}" target="_blank">{{ $tag }}</a> </span>
        </div>
    @endif
    <div class="{{ $block->elem('socials') }}">
        {!! $renderer->renderBlock('partials/social-share', [
            'data' => $socialShare,
        ]) !!}
    </div>
</div>
