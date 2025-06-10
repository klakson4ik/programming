<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'outcome',
        'caption' => $title,
        'captionStyle' => 'bold',
        'fields' => [
            [
                'name' => 'not_applicable',
                'label' => 'Не применимо',
            ],
            [
                'name' => 'recovery_without_consequences',
                'label' => 'Выздоровление без последствий',
            ],
            [
                'name' => 'condition_improvement',
                'label' => 'Улучшение состояния',
            ],
            [
                'name' => 'status_unchanged',
                'label' => 'Состояние без изменений',
            ],
    
            [
                'name' => 'death',
                'label' => 'Смерть',
            ],
            [
                'name' => 'unknown',
                'label' => 'Неизвестно',
            ],
            [
                'name' => 'recovery_with_consequences',
                'label' => 'Выздоровление с последствиями (указать)',
                'input' => [
                    'name' => 'recovery_with_consequences_desc',
                    'style' => 'below',
                ],
            ],
        ],
    ]) !!}
</div>
