<div id="{{ $block }}" class="{{ $block }}">
    <div class="c-container">
        <h2 class="{{ $block }}__title">
            {!! $title !!}
        </h2>
    </div>
    <div class="{{ $block }}__picture">
        @include('component.picture', ['img' => $bg])
    </div>
</div>
