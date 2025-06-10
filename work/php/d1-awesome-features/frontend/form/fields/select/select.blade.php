<div class="b-select hidden @if($mods) {{ implode(' ', $mods) }} @endif" @if ($event) data-event="{{ $event ?? '' }}" @endif
    @if ($props) @foreach ($props as $prop => $value)
				data-{{ $prop }}="{{ $value }}"
			@endforeach @endif>
    @if ($label)
        <label @if ($id) for="{{ $id }}" @endif class="b-select__label">
            {{ $label }}
        </label>
    @endif
    <button @if ($id) id="{{ $id }}" @endif class="b-select__input" type="select"
        name="{{ $name }}" value="" aria-expanded="false"
		role="combobox"
  		aria-label="select button"
  		aria-haspopup="listbox"
  		aria-controls="select-dropdown"
		@if ($required) required @endif
		@if ($disabled) disabled @endif
		>
        <span
            class="b-select__value">{{ reset(array_filter($items, fn($item) => $item['selected']))['caption'] ?? ($placeholder ?? '') }}</span>
        <span class="b-select__arrow">{!! $arrow ?? '' !!}</span>
    </button>
    @if ($items)
        <div class="b-select__dropdown">
            <ul class="b-select__list"
				role="listbox"
  				id="select-dropdown"
  				aria-labelledby="dropdown-button"
			>
                @foreach ($items as $item)
                    <li class="b-select__item" 
					@if ($item['selected']) selected="selected" @endif
					@if ($disabled) disabled @endif
                        value="{{ $item['value'] }}">
                        {!! $item['caption'] !!}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
