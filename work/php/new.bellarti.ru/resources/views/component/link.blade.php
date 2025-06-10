<div class="custom-link">
    @if (isset($url) && isset($title))
        <a href="{{ $url }}"
            class="c-trans c-white c-bg-purple c-uppercase c-border-purple custom-link-title">{!! $title !!}</a>
    @else
        <span class="c-uppercase c-border-purple custom-link-title">Ссылка недоступна</span>
    @endif
</div>
