<a target="_blank" href="{{ getLink('/storage/' . $file) }}" class="{{ $block }}__content" itemscope
    itemtype="http://schema.org/Person">
    <img class="{{ $block }}__image" src="{{ $image }}" alt="{{ $name }}" title="{{ $name }}"
        itemprop="image">
    <p class="c-purple-dark c-uppercase {{ $block }}__name" itemprop="name">{{ $name }}</p>
    <p class="c-gray-light {{ $block }}__position" itemprop="jobTitle">{{ $speciality }}</p>
    <p class="c-black c-font-subtitle {{ $block }}__description" itemprop="description">{{ $title }}</p>
    <p class="c-black c-uppercase c-bold {{ $block }}__link">{{ $name_link }} {!! $card['arrow'] !!}
    </p>
</a>
