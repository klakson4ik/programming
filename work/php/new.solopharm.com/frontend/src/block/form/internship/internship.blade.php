<form
	class="{{ $block }}"
	id="internship"
	name="internship"
	method="post"
	action="/{{ request()->path() }}"
	enctype="multipart/form-data"
>
	@csrf
	<div class="{{ $block->elem('top') }}">
		<div class="{{ $block->elem('exclamation') }}">!</div>
		<p class="{{ $block->elem('city-note') }}">{!! __('form.city-note') !!}</p>
	</div>
	<div class="{{ $block->elem('fields') }}">
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'name' => 'name',
				'label' => __('form.fio'),
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'name' => 'university',
				'label' => __('form.university'),
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'name' => 'course',
				'label' => __('form.course'),
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'name' => 'faculty',
				'label' => __('form.faculty'),
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'name' => 'date_start',
				'type' => 'date',
				'label' => __('form.date-start'),
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'name' => 'date_end',
				'type' => 'date',
				'label' => __('form.date-end'),
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'type' => 'tel',
				'name' => 'phone',
				'label' => __('form.phone'),
				'pattern' => '^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$',
				'errors' => [ 
					'error' => __('form.errors.phone')
				],
				'placeholder' => '+7 (999) 999-99-99',
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'type' => 'email',
				'name' => 'email',
				'label' => __('form.email'),
				'pattern' => '^[\w\-.]+@([\w-]+\.)+[\w-]{2,4}$',
				 'errors' => [ 
					'error' => __('form.errors.email')
				],
				'placeholder' => 'example@mail.com',
				'required' => true
			]) !!}
		</div>
		@isset($page->form_directions)
			<div class="{{ $block->elem('field') }}">
				{!! $renderer->renderBlock('field/select', [
					'name' => 'direction',
					'label' => __('form.direction'),
					'options' => array_map(fn($item) => $item['value'], $page->form_directions),
					'required' => true
				]) !!}
			</div>
		@endisset
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderBlock('field/input', [
				'type' => 'file',
				'name' => 'file',
				'label' => __('form.resume'),
				'accept' => 'application/msword, .pdf',
				'placeholder' => 'doc, docx, pdf',
				'required' => true
			]) !!}
		</div>
		<div class="{{ $block->elem('bottom') }}">
			<p class="{{ $block->elem('policy') }}">{!! __('form.policy.internship') !!}</p>
			{!! $renderer->renderBlock('common/button', [
				'type' => 'submit',
				'name' => 'send',
				'text' => 'Отправить',
				'icon' => 'arrow-long',
			]) !!}
		</div>
		<div class="{{ $block->elem('field') }}">
			{!! $renderer->renderblock('field/textarea', [
                'name' => 'letter',
                'label' => __('form.letter'),
                'rows' => '4',
				'mod' => ['gray', 'no-margin-bottom'],
                'required' => true,
            ]) !!}
		</div>
	</div>
</form>
