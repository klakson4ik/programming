<div class="{{ $block }}">
    @foreach ($sites as $site)
        <div class="{{ $block->elem('elem') }}">
            <a href="{{ routeName() . '/' . $site->link }}" class="{{ $block->elem('site') }}">
				<img class="{{ $block->elem('img')}}" src="/storage/{{ $site->img}}" alt="{{ $site->title}}" title="{{ $site->title}}" />
                <img  class="{{ $block->elem('s')}}" src="/images/gallery-S.png" />
            </a>
            <p class="{{ $block->elem('title') }}">
                {!! $site->title !!}
            </p>
        </div>
    @endforeach
</div>
