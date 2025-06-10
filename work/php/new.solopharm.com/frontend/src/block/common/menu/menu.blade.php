<nav class="{{ $block }}" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
    <ul class="{{ $block->elem('level')->mod('root') }}">
        {!! $renderer->renderBlock('common/menu/level', [
            'data' => $menuItems,
            'level' => 1,
        ]) !!}
    </ul>
</nav>
