<div class="{{ $block }}" style='background-image: url("{{ asset('storage/' . $form->img) }}");'>
    @isset($form->title)
        <p class="{{ $block->elem('title') }}">
            {{ $form->title }}
        </p>
    @endisset
    @isset($form->text)
        <p class="{{ $block->elem('text') }}">
            {{ $form->text }}
        </p>
    @endisset
</div>
