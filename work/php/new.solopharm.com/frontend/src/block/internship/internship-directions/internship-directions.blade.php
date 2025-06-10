<div class="{{ $block }}">
    <p class="{{ $block->elem('title') }}">
        {!! $page->internship_directions_title !!}
    </p>
    <ul class="{{ $block->elem('directions-list') }}">
        @foreach($page->form_directions as $direction)
            <li class="{{ $block->elem('item') }}">{!! $direction['value'] !!}</li>
        @endforeach
    </ul>
</div>