@foreach ($data as $item)
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ItemList">
        @if (!$item->children->isEmpty() && $level != 2 && $item->url !== 'products')
            <i class="b-burger__menu-btn">
                {!! $renderer->renderBLock('common/icon', [
                    'icon' => 'arrow-short',
                ]) !!}
            </i>
        @endif
        <a {!! $item->children->isEmpty() && $level != 2 || $item->not_show_childs == 1 ? 'class="b-burger__menu--no-arrow"' : '' !!} href="/{{ locale() . $item->url }}" itemprop="url">{!! $item->name !!}</a>
        <meta itemprop="name" content="{!! $item->name !!}" />
        @if (!$item->children->isEmpty() && $level != 2 && $item->not_show_childs !== 1)
            <ul class="b-burger__menu-level--{{ $level }}">
                {!! $renderer->renderBLock('common/burger/level', [
                    'data' => $item->children,
                    'level' => $level + 1,
                ]) !!}
            </ul>
        @else
            <div class="b-burger__menu-level--1"></div>
        @endif
    </li>
@endforeach
