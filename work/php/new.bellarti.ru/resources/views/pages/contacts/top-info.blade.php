<section id="{{ $block }}" class="{{ $block }}" style="background-image: url({{ $bg }})">
    <div class="c-container {{ $block }}__container">
		@include('common.breadcrumbs', ['type'=> 'b-breadcrumbs--background'])
        <h2 class="{{ $block }}__title c-h1">
            {!! $title !!}
        </h2>
    </div>
</section>
