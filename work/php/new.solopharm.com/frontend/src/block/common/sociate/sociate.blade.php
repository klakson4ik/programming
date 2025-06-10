<div class="{{ $block }}">
    @foreach ($data as $key => $item)
        <a href="{{ $item }}" target="_blank"><img src="/images/icons/{{ $key }}.svg" alt="{{ $key }}"
                title="{{ $key }}"></a>
    @endforeach
</div>
