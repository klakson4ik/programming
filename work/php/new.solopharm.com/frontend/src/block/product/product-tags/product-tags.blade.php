<ul class="{{ $block }}">
    @if($choiceFilters)
        @foreach ($choiceFilters as $name => $item)
            @if ($name === 'id' && $directionIds)
                @foreach ($directionIds as $id)
                    @foreach ($directions as $direction)
                        @if ($direction->id == $id)
                            <li class="{{ $block->elem('tag') }}">
                                <span>#{{ $direction->name }}</span>
                                <button class="{{ $block->elem('del') }}"
                                    name="{{ $direction->url_slug }}">{!! $renderer->renderBlock('common/icon', [
                                        'icon' => 'close',
                                    ]) !!}</button>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            @else
                <li class="{{ $block->elem('tag') }}">
                    <span>#{{ __('pages.' . $name) }}</span>
                    <button class="{{ $block->elem('del') }}" name="{{ $returnName ?? $name }}">{!! $renderer->renderBlock('common/icon', [
                        'icon' => 'close',
                    ]) !!}</button>
                </li>
            @endif
        @endforeach
    @endif
</ul>
