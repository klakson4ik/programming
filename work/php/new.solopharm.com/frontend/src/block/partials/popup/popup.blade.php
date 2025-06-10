@php
	$stylies = [
		'width' => isset($width) ? $width : false,
		'height' => isset($height) ? $height : false,
		'bg' => isset($bg) ? $bg : false,
	];

	$str = false;
	foreach ($stylies as $style => $value) {
		if ($value) {
			$str .= $style . ':' . $value . ';';
		}
	}

	if ($str) {
		$str = 'style=' . $str;
	}

@endphp
<div class="{{ $block }}">
	<div class="{{ $block->elem('container') }}">
	</div>
	<div class="{{ $block->elem('window')->mod(isset($panorama) ? 'panorama' : '') }}" {{ $str ?: '' }}>
		<button class="{{ $block->elem('window-close') }}">
			{!! $renderer->renderBlock('common/icon', [
				'icon' => 'close',
			]) !!}
		</button>
		<div class="{{ $block->elem('window-content') }}">
			@if (isset($fullWidth))
				{!! $content !!}
			@elseif (isset($video) || isset($panorama))
				<div class="{{ $block->elem('video') }}">
					<div class="{{ $block->elem('video-wrap') }}">
						@isset($video)
							@if(isset($videoFile) && $videoFile === true)
								<video class="{{ $block->elem('video-item') }}" width="800" height="600" controls>
									<source src="{{ asset('storage') . '/' . $video}}">
								</video>
							@else
							<iframe width="800" height="600"
									src="
                                @if(isset($videoType) && $videoType === 'rutube')
									https://rutube.ru/play/embed/{{ $video }}
								@else
									https://www.youtube.com/embed/{{ $video }}?enablejsapi=1
                                @endif
                                " frameborder="0"
									allowfullscreen>
							</iframe>
							@endif
						@else
							<iframe class="{{ $block->elem('panorama')}}" width="800" height="600"
									data-src="/{{ $panorama }}">
							</iframe>
						@endisset
					</div>
				</div>
			@else
				<div class="{{ $block->elem('window-container') }}">
					@isset($header)
						<div class="{{ $block->elem('window-header') }}">
							{!! $header !!}
						</div>
					@endisset
					<div class="{{ $block->elem('window-content') }}">
						{!! $content !!}
					</div>
					@isset($footer)
						<div class="{{ $block->elem('window-content') }}">
							{!! $footer !!}
						</div>
					@endisset
				</div>
			@endif
        </div>
    </div>
</div>
