<article class="{{ $block }}">
    <a href="/{{ $url }}" class="{{ $block->elem('title') }}">
       <span class="{{ $block->elem('tag') }}">
        {!! $tag !!}
       </span>{!! $title !!} 
    </a>
    <div class="{{ $block->elem('text') }}">
       {!! mb_strimwidth(strip_tags($text), 0, 250, "..."); !!} 
    </div>
</article>
