@php
    $search = Request::query('search') ? '&search=' . Request::query('search') : false;
@endphp
<div class="{{ $block }}">
    <div class="{{ $block->elem('line') }}">
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <a class="{{ $block->elem('line-item')->mod($page == $paginator->currentPage() ? 'current' : '') }}"
                        href="{{ $url }}">
                        <div></div>
                    </a>
                @endforeach
            @endif
        @endforeach
    </div>
    <div class="{{ $block->elem('arrows') }}">
        <span class="{{ $block->elem('nav-left') }}">
            {!! $renderer->renderBlock('common/arrow', [
                'left' => true,
                'url' =>
                    ($paginator->onFirstPage() ? $paginator->url($paginator->lastPage()) : $paginator->previousPageUrl()) .
                    $search ?:
                    '',
            ]) !!}
        </span>
        <span class="{{ $block->elem('nav-right') }}">
            {!! $renderer->renderBlock('common/arrow', [
                'url' => ($paginator->hasMorePages() ? $paginator->nextPageUrl() : $paginator->url(1)) . $search ?: '',
            ]) !!}
        </span>
    </div>
</div>
