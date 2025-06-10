@foreach ($data as $item)
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ItemList">
        <a href="/{{ $item['code'] ?? '/' }}" class="c-trans-color c-black smooth-scroll {{ $level == 1 ? 'c-bold c-uppercase' : '' }}"
            itemprop="url">{!! $item['name'] !!}
        </a>
        @if ($arrow && isset($item['children']))
            <span class="b-menu__arrow">
                @include('component.arrow-select')
            </span>
        @endif
        <meta itemprop="name" content="{!! $item['name'] !!}" />
        @if (isset($item['children']) && $level != $levelMax)
            <ul class="smooth-scroll b-menu__level--{{ $level }}">
                @include('common/menu/level', [
                    'data' => $item['children'],
                    'level' => $level + 1,
                    'levelMax' => $levelMax,
                    'arrow' => $arrow ?? false,
                ])
            </ul>
        @endif
    </li>
@endforeach
