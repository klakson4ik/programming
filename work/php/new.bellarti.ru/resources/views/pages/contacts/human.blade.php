<div class="{{ $block }}__human" itemscope itemtype="http://schema.org/Person"
    data-caption="{{ $item['district_id'] ?? '' }}">
    <p class="c-font-subtitle {{ $block }}__human-name" itemprop="name">{!! $item['name'] !!}</p>
    <p class="{{ $block }}__human-post" itemprop="jobTitle">{!! $item['post'] !!}</p>
    <a href="tel:{{ getPhoneField($item['number']) }}" itemprop="telephone"
        class="c-black c-trans-color {{ $block }}__human-number">{{ $item['number'] }}
        {{ $item['addNumber'] ?? '' }}</a>
    <a href="mailto:{{ $item['email'] }}" itemprop="email"
        class="c-purple-dark {{ $block }}__human-email">{{ $item['email'] }}</a>
</div>
