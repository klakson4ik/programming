<section id="{{ $block }}" class="c-container {{ $block }}">
    <h2 class="c-purple-dark {{ $block }}__title">{{ $title }}</h2>
    <div class="{{ $block }}__wrapper">
        @foreach ($items as $item)
            @include('pages.contacts.human', $item)
        @endforeach
    </div>
</section>
