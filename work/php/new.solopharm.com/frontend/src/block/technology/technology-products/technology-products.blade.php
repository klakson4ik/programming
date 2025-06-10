<div class="{{ $block }}">
    @if (!$data->isEmpty())
        <div class="{{ $block->elem('list') }}">
            <h1 class="c-h2">{!! $title !!}</h2>
                <div class="{{ $block->elem('container') }}">
                    @foreach ($data as $item)
                        <a href="/{{ locale() . 'products/' . $item->product->url_slug . '/' . $item->url_slug }}"
                            class="{{ $block->elem('item') }}">
                            <p>{{ $item->product->title }}</p>
                            <img src="/storage/{{ $item->img }}">
                        </a>
                    @endforeach
                </div>
        </div>
    @else
        <div class="{{ $block->elem('list-empty')}}"></div>
    @endif
</div>
