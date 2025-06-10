<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'measures_taken',
        'caption' => $title,
        'captionStyle' => 'bold',
        'fields' => [
            [
                'name' => 'without_treatment',
                'label' => 'Без лечения',
            ],
            [
                'name' => 'cancel_drug',
                'label' => 'Отмена подозреваемого лекарственного средства',
            ],
            [
                'name' => 'reducing_dose',
                'label' => 'Снижение дозы лекарственного средства',
            ],
              [
                'name' => 'drug_therapy',
                'label' => 'Лекарственная терапия',
                'input' => [
                    'name' => 'drug_therapy_desc'
                ]
            ],
        ],
    ]) !!}
</div>
