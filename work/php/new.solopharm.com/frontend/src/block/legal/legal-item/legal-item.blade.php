<a href="/storage/{{ $legal->data }}" class="{{ $block }}" target="_blank">
    <p class="{{ $block->elem('title') }}">
        {{ $legal->title }}
    </p>
    <p class="{{ $block->elem('bottom') }}">
        {{ __('pages.document') }}: pdf
    </p>
</a>
