<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'repeat_drug',
        'caption' => $title,
        'captionStyle' => 'bold',
        'fields' => [
            [
                'name' => 'no',
                'label' => 'Нет',
            ],
            [
                'name' => 'yes',
                'label' => 'Да, результат',
                'input' => [
                    'name' => 'yes_result',
                ],
            ],
            [
                'name' => 'not_applicable',
                'label' => 'Не применимо',
            ],
        ],
    ]) !!}
</div>
