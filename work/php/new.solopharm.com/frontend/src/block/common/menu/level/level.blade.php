@foreach ($data as $item)
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ItemList">
        <a {!! !$item->children->isEmpty() && $level == 2 ? 'class="b-menu--arrow"' : '' !!} href="/{{ locale() . $item->url ?: '/#' }}" itemprop="url">{!! $item->name !!}
            @if (!$item->children->isEmpty() && $level != 2)
                <i class="b-menu__btn">
                    {!! $renderer->renderBLock('common/icon', [
                        'icon' => 'arrow-short',
                    ]) !!}
                </i>
            @endif
        </a>
        <meta itemprop="name" content="{!! $item->name !!}" />
        @if (!$item->children->isEmpty() && $level != 3)
            <ul class="b-menu__level--{{ $level }}">
                {!! $renderer->renderBLock('common/menu/level', [
                    'data' => $item->children,
                    'level' => $level + 1,
                ]) !!}
            </ul>
        @endif
    </li>
@endforeach
