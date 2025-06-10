<header class="{{ $block }} c-container">
    <a class="{{ $block->elem('logo') }}" href="/"><img src="/images/icons/logo.svg" alt="logo"></a>
    <div class="{{ $block->elem('menu') }}">
        {!! $renderer->renderBlock('common/menu', [
            'menuItems' => $menuItems,
            'level' => 1,
        ]) !!}
    </div>
    <div class="{{ $block->elem('options') }}">
        <div class="{{ $block->elem('search') }}">
            <i class="{{ $block->elem('search-icon') }}">
                {!! $renderer->renderBlock('common/icon', [
                    'icon' => 'search',
                ]) !!}
            </i>
            <a href="/search" class="{{ $block->elem('search-icon-mobile') }}">
                {!! $renderer->renderBlock('common/icon', [
                    'icon' => 'search',
                ]) !!}
            </a>
        </div>
        <ul class="{{ $block->elem('lang') }}">
            <li>
                <a>
                    @if (app()->getLocale() == 'ru')
                        ENG
                    @else
                        РУС
                    @endif
                </a>
                @if ($locales)
                    <ul class="{{ $block->elem('lang-list') }}">
                        @foreach ($locales as $item)
                            <li><a href="{{ $item == app()->getLocale() ? '' : '/switch-lang/' . $item }}" noindex>
                                    @if ($item == 'ru')
                                        РУС
                                    @else
                                        ENG
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        </ul>
        <div class="{{ $block->elem('hamburger') }}">
            <div></div>
            <div class="{{ $block->elem('hamburger-vanish') }}"></div>
            <div></div>
        </div>
    </div>
    <form class="{{ $block->elem('search-form') }}" action="/{{ locale() }}search" method="get">
        <i class="{{ $block->elem('search-icon') }}">
            {!! $renderer->renderBlock('common/icon', [
                'icon' => 'search',
            ]) !!}
        </i>
        <input type="text" name="query" placeholder="{{ __('pages.header.search-placeholder') }}" autofocus>
    </form>
    <div class="{{ $block->elem('burger') }}">
        {!! $renderer->renderBlock('common/burger', [
            'info' => $info,
            'locales' => $locales,
            'menuItems' => $menuItems,
            'level' => 1,
        ]) !!}
    </div>
</header>
