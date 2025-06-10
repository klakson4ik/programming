<p class="{{ $block->elem('subtitle') }} subtitle">{!! $title !!}</p>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'name',
        'label' => 'Инициалы пациента (код пациента)',
        'required' => true,
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'gender',
        'caption' => 'Пол',
        'fields' => [
            [
                'name' => 'men',
                'label' => 'Мужской',
            ],
            [
                'name' => 'woman',
                'label' => 'Женский',
            ],
        ],
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'weight',
        'label' => 'Вес, кг',
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'pregnant',
        'caption' => 'Беременность',
        'fields' => [
            [
                'name' => 'no',
                'label' => 'Нет',
            ],
            [
                'name' => 'yes',
                'label' => 'Есть, срок в неделях',
                'input' => [
                    'name' => 'pregnant_term',
                ],
            ],
        ],
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'allergy',
        'caption' => 'Аллергия',
        'fields' => [
            [
                'name' => 'no',
                'label' => 'Нет',
            ],
            [
                'name' => 'yes',
                'label' => 'Есть, на',
                'input' => [
                    'name' => 'allergy_on',
                ],
            ],
        ],
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'treatment',
        'caption' => 'Лечение',
        'fields' => [
            [
                'name' => 'outpatient',
                'label' => 'Амбулаторное',
            ],
            [
                'name' => 'stationary',
                'label' => 'Стационарное',
            ],
            [
                'name' => 'self_medication',
                'label' => 'Самолечение',
            ],
        ],
    ]) !!}
</div>
