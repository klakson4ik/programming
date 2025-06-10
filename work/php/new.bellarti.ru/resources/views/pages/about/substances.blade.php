<section class="c-container {{ $block }}" id="{{ $block }}">
    <div class="{{ $block }}__detail">
        <h3 class="{{ $block }}__detail-title">{{ $title }}</h3>
		<div class="{{$block}}__detail-wrapper">
        @foreach ($items as $item)
            <div class="{{$block}}__detail-item">
                <p class="c-purple-dark c-uppercase {{ $block }}__detail-subtitle">{!! $item['title'] !!}</p>
                <p class="{{ $block }}__detail-desc">{!! $item['desc'] !!}</p>
            </div>
        @endforeach
		</div>
    </div>
    <div class="{{ $block }}__picture c-rel">
        @include('component.picture', $img)
    </div>
</section>
