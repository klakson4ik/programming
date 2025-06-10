 <p class="{{ $block->elem('subtitle') }} subtitle">{!! $title !!}</p>
 <div class="{{ $block->elem('appear')}} suspect">
    <div class="{{ $block->elem('field') }}">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'drug_1',
            'label' => 'Наименование лекарственного средства / медицинского изделия',
            'required' => true,
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'manufacturer_1',
            'label' => 'Производитель (см. на упаковке)',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'series_1',
            'label' => 'Номер серии (см. на упаковке)',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'dose_1',
            'label' => 'Доза, путь введения',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'start_data_therapy_1',
            'label' => 'Дата начала терапии',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'end_data_therapy_1',
            'label' => 'Дата окончания терапии',
        ]) !!}
    </div>
    <div class="{{ $block->elem('field') }} field">
        {!! $renderer->renderBlock('field/input', [
            'name' => 'suspect_' . 'indications_1',
            'label' => 'Показания',
        ]) !!}
    </div>
 </div>

 <input type="hidden"  name="suspect_count" value="1" />

 {!! $renderer->renderblock('form/reaction-medical/add-drug-btn', [
     'name' => 'suspect',
     'icon' => 'plus',
     'caption' => 'Добавить препарат',
 ]) !!}
