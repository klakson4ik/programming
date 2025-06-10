<div>
    <h2 class="c-h2">
        {{ $data->title }}
    </h2>
    <div class="{{ $block }}">
        <div class="{{ $block->elem('column-left') }}">
            {!! $data->text !!}
            @if ($data->youtube)
                {!! $renderer->renderBlock('common/button', [
                    'type' => 'button',
                    'name' => 'video',
                    'text' => __('pages.watch-video'),
                    'icon' => 'watch',
                ]) !!}
                {!! $renderer->renderBlock('/partials/popup', [
                    'video' => $data->youtube
                ]) !!}
            @endif
        </div>
        <div class="{{ $block->elem('column-right') }}">
            <img src="/storage/{{ $data->img }}" alt="{{ __('pages.photo') . ' ' . $data->title }}" title="{{ $data->title }}">
        </div>
    </div>
</div>
