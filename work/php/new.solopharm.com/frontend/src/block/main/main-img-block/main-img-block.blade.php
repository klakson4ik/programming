<div class="{{ $block }}" style='background-image: url("{{ asset('storage/' . $img) }}");'>
    <p class="ctext">{!! $text1 !!}</p>
    <div class="{{ $block->elem('text') }} iconS">
        <h1>{{ $title }}</h1>
        <div class="{{ $block->elem('delim') }}"></div>
        <h2 class="{{ $block->elem('bottom') }}">
            {!! $text2 !!}
            @if (isset($youtube))
                <div class="{{ $block->elem('btn') }}">
                    {!! $renderer->renderBlock('common/button', [
                        'type' => 'button',
                        'name' => 'youtube',
                        'text' => __('pages.main.video_about_company'),
                        'icon' => 'arrow-long',
                    ]) !!}
                </div>
            @endif
        </h2>
    </div>
</div>
@if (isset($youtube))
    {!! $renderer->renderBlock('/partials/popup', [
        'video' => $youtube,
        'videoFile' => $videoFile ?? false
    ]) !!}
@endif
