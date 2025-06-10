<picture class="b-picture">
    @isset($img['mods']['540'])
        <source srcset="{{ $img['mods']['540'] }}" media="(max-width: 539px)">
    @endisset
    @isset($img['mods']['768'])
        <source srcset="{{ $img['mods']['768'] }}" media="(max-width: 767px)">
    @endisset
    @isset($img['mods']['1366'])
        <source srcset="{{ $img['mods']['1366'] }}" media="(max-width: 1365px)">
    @endisset
    <img src="{{ $img['src'] }}" loading="lazy" itemprop="image" />
</picture>
