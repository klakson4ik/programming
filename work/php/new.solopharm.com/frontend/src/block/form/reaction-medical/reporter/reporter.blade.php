<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'reporter',
        'caption' => $title,
        'captionStyle' => 'bold',
        'fields' => [
            [
                'name' => 'doctor',
                'label' => 'Врач',
            ],
            [
                'name' => 'other_specialist',
                'label' => 'Другой специалист системы здравоохранения',
            ],
            [
                'name' => 'patient',
                'label' => 'Пациент',
            ],
            [
                'name' => 'other',
                'label' => 'Иной',
            ],
        ],
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'fio',
        'label' => 'ФИО (можно указать инициалы)',
        'required' => true
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'position',
        'label' => 'Должность и место работы',
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'date',
        'label' => 'Дата обращения',
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'type' => 'tel',
        'name' => 'phone',
        'label' => 'Телефон',
        'required' => true,
        'pattern' => '^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$',
        'errors' => [
            'error' => __('form.errors.phone'),
        ],
        'placeholder' => '+7 (999) 999-99-99',
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'type' => 'email',
        'name' => 'email',
        'label' => 'E-mail',
        'required' => true,
        'pattern' => '^[\w\-.]+@([\w-]+\.)+[\w-]{2,4}$',
        'errors' => [
            'error' => __('form.errors.email'),
        ],
        'placeholder' => 'example@mail.com',
    ]) !!}
</div>
