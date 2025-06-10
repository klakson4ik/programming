<div class="{{ $block->elem('field') }} field">
    {!! $renderer->renderBlock('field/radio', [
        'name' => 'other_drugs',
        'caption' => $title,
        'captionStyle' => 'bold',
        'fields' => [
            [
                'name' => 'no',
                'label' => 'Нет',
            ],
            [
                'name' => 'yes',
                'label' => 'Да',
            ],
        ],
    ]) !!}
</div>
 <div class="{{ $block->elem('appear')}} other">
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'drug_1',
            'label' => 'Наименование лекарственного средства / медицинского изделия',
            'required' => true,
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'manufacturer_1',
            'label' => 'Производитель (см. на упаковке)',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'series_1',
            'label' => 'Номер серии (см. на упаковке)',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'dose_1',
            'label' => 'Доза, путь введения',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'start_data_therapy_1',
            'label' => 'Дата начала терапии',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'end_data_therapy_1',
            'label' => 'Дата окончания терапии',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'other_' . 'indications_1',
            'label' => 'Показания',
        ]) !!}
    </div>
</div>
<input type="hidden"  name="other_count" value="1" />
{!! $renderer->renderblock('form/reaction-medical/add-drug-btn', [
    'name' => 'other',
    'icon' => 'plus',
    'caption' => 'Добавить препарат',
]) !!}
