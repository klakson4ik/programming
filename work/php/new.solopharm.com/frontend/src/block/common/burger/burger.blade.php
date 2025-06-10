<div class="{{ $block }} c-container">
    <nav class="{{ $block->elem('menu') }}" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
        <ul class="{{ $block->elem('menu')->mod('root') }}">
            {!! $renderer->renderBlock('common/burger/level', [
                'data' => $menuItems,
                'level' => 1,
            ]) !!}
        </ul>
    </nav>
    <ul class="{{ $block->elem('lang') }}">
        @foreach ($locales as $item)
            <li class="{{ $block->elem('lang-item')->mod(app()->getLocale() === $item ? 'active' : '') }}"><a
            href="/switch-lang/{{ $item }}" noindex>
                    @if ($item == 'ru')
                        РУС
                    @else
                        ENG
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
    @if (!empty($info->sociate))
        <div class="{{ $block->elem('sociate') }}">
            <div class="{{ $block->elem('sociate') }}">
                {!! $renderer->renderBlock('common/sociate', [
                    'data' => $info->sociate,
                ]) !!}
            </div>
        </div>
    @endif
    <i class="{{ $block->elem('logo') }}">
        <img src="/images/icons/s-dark.svg">
    </i>
</div>
