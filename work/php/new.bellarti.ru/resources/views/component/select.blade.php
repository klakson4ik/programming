<div class="b-select" data-event="{{ $event ?? ''}}">
    <button class="b-select__btn btn" type="button" name="select">
        <span class="b-select__value">{{ $selected ?? '' }}</span>
        <span class="b-select__icon icon">{!! $icon !!}</span>
    </button>
    <div class="b-select__dropdown dropdown">
        <fieldset class="b-select__list list">
            @foreach ($items as $value => $caption)
                <p class="b-select__item item {{ $selected == $caption ? 'selected' : ''}}" data-value="{{ $value }}" data-caption="{{ $caption }}">
                    {!! $caption !!}
                </p>
            @endforeach
        </fieldset>
    </div>
</div>
