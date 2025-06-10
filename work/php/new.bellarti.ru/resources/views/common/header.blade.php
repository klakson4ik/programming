<div class="c-container b-header">
    <a href="/" class="c-trans-color c-black b-header__logo">
        {!! $data['logo'] !!}
    </a>
    <div class="c-since-lg b-header__menu">
        @include('common.menu.root', $data)
    </div>
    <a href="{{ $data['logo-solo']['link'] }}" target="_blank" class="c-since-lg c-purple-dark b-header__logo-solo">
        {!! $data['logo-solo']['icon'] !!}
    </a>
    <button class="b-header__hamburger" type="button">
        <span class="b-header__hamburger-bar"></span>
    </button>
    <div class="c-till-lg b-header__mobile-menu">
        @include('common.menu.root', $data, ['arrow' => getCommonIcon('arrow-45')])
        <a href="{{ $data['logo-solo']['link'] }}" target="_blank" class="c-purple-dark b-header__logo-solo b-header__logo-solo--mobile">
            {!! $data['logo-solo']['icon'] !!}
        </a>
    </div>
</div>
