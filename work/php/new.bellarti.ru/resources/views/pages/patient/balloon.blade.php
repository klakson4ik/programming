<div class="b-balloon">
    <h4 class="c-font-subtitle c-purple-dark">{!! $name !!}</h4>
    <div class="b-balloon__content">
        @if ($address)
            <p class="b-balloon__address">
                {!! $address !!}
            </p>
        @endif
        @if ($phone)
            <a href="tel:{{ getPhoneField($phone) }}" class="b-balloon__phone">
                {!! $phone !!}
            </a>
        @endif
        @if ($mail)
            <a href="mailto:{{ $mail }}" class="b-balloon__mail">
                {!! $mail !!}
            </a>
        @endif
        @if ($description)
            <p class="b-balloon__desc">
                {!! $description !!}
            </p>
        @endif
    </div>
	<button class="c-purple-dark b-balloon__close">{!! getCommonIcon('cross') !!}</button>
</div>
