<nav class="b-menu" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
    <ul class="b-menu__level b-menu__level--root">
        @include('common/menu/level', [
            'data' => $menu,
            'level' => 1,
			'levelMax' => $levelMax ?? 3,
			'arrow' => $arrow ?? false
        ])
    </ul>
</nav>
