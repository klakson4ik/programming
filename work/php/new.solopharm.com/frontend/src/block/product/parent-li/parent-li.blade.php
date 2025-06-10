<div
	class="{{ $block }}"
	@isset($code)
		data-code="{{ $code }}"
	@endisset
>
	<span class="{{ $block->elem('dropdown-icon') }}">
		{!! $renderer->renderBLock('common/icon', [
			'icon' => 'arrow-short',
		]) !!}
	</span>
	<span class="{{ $block->elem('text') }}">{{ isset($text) ? $text : '' }}</span>
</div>
