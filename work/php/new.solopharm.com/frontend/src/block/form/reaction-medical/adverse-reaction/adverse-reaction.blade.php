<p class="{{ $block->elem('subtitle') }} subtitle">{!! $title !!}</p>
<div class="{{ $block->elem('field') }}">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'data_start_adverse_reaction',
        'label' => 'Дата начала нежелательной реакции',
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'desc_reaction',
        'label' => 'Описание реакции (укажите все детали, включая данные лабораторных исследований)',
        'required' => true,
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'adverse_reaction_criteria',
        'caption' => 'Критерии серьезности нежелательной реакции',
        'fields' => [
            [
                'name' => 'not_applicable',
                'label' => 'Не применимо',
            ],
    
            [
                'name' => 'life_threat',
                'label' => 'Угроза жизни',
            ],
            [
                'name' => 'hospitalization ',
                'label' => 'Госпитализация или ее продление',
            ],
            [
                'name' => 'disability',
                'label' => 'Инвалидность',
            ],
            [
                'name' => 'anomalies',
                'label' => 'Врожденные аномалии',
            ],
            [
                'name' => 'clinically_event',
                'label' => 'Клинически значимое событие',
            ],
            [
                'name' => 'death',
                'label' => 'Смерть',
            ],
        ],
    ]) !!}
</div>
<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/input', [
        'name' => 'data_adverse_reaction_resalution',
        'label' => 'Дата разрешения нежелательной реакции',
    ]) !!}
</div>
