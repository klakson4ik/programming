<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'cancel_adverse_reaction',
        'caption' => $title,
        'captionStyle' => 'bold',
        'fields' => [
            [
                'name' => 'not_applicable',
                'label' => 'Не применимо',
            ],
    
            [
                'name' => 'yes',
                'label' => 'Да',
            ],
            [
                'name' => 'no',
                'label' => 'Нет',
            ],
            [
                'name' => 'drug_not_canceld',
                'label' => 'Средство/изделие не отменялось',
            ],
        ],
    ]) !!}
</div>
