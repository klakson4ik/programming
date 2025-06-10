<form class="{{ $block }}" id="reaction-patient" name="reaction-patient" method="post"
    action="/{{ request()->path() }}" enctype="multipart/form-data">
    @csrf
    <div class="{{ $block->elem('fields') }}">
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/radio', [
                'name' => 'who',
                'caption' => 'Кем вы являетесь',
                'fields' => [
                    [
                        'name' => 'patient',
                        'label' => 'Пациент',
                    ],
                    [
                        'name' => 'relative',
                        'label' => 'Родственник пациента',
                        
                    ],
                    [
                        'name' => 'other',
                        'label' => 'Другой',
                        'input' => [
                            'name' => 'other_name',
                        ],
                    ],
                ],
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'fio',
                'label' => 'ФИО (можно указать инициалы)',
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('other-del')->mod('active') }}">

            <div class="{{ $block->elem('field') }}">
                {!! $renderer->renderBlock('field/input', [
                    'name' => 'age',
                    'label' => 'Возраст (количество дней, месяцев, лет)',
                    'required' => true,
                ]) !!}
            </div>
            <div class="{{ $block->elem('field') }}">
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
        </div>
        <div class="{{ $block->elem('field') }}">
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
        <div class="{{ $block->elem('field') }}">
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
        <div class="{{ $block->elem('other-add') }}">
            <p class={{ $block->elem('subtitle') }}>О пациенте</p>
            <div class="{{ $block->elem('field') }}">
                {!! $renderer->renderBlock('field/input', [
                    'name' => 'fio_patient',
                    'label' => 'ФИО (можно указать инициалы)',
                ]) !!}
            </div>
            <div class="{{ $block->elem('field') }}">
                {!! $renderer->renderBlock('field/input', [
                    'name' => 'age_patient',
                    'label' => 'Возраст (количество дней, месяцев, лет)',
                ]) !!}
            </div>
            <div class="{{ $block->elem('field') }}">
                {!! $renderer->renderBlock('field/radio', [
                    'name' => 'gender_patient',
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
        </div>
        <p class={{ $block->elem('subtitle') }}>О лекарственном средстве / медицинском изделии</p>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'product',
                'label' => 'Название лекарственного средства / медицинского изделия',
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'manufacturer',
                'label' => 'Производитель (см. на упаковке)',
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'series',
                'label' => 'Серия (см. на упаковке)',
            ]) !!}
        </div>
        <p class={{ $block->elem('subtitle') }}>Описание случая</p>
        <div class="{{ $block->elem('textarea') }}">
            {!! $renderer->renderblock('field/textarea', [
                'name' => 'case',
                'label' => 'Опишите произошедший случай в произвольной форме',
                'rows' => '4',
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/file', [
                'type' => 'file',
                'name' => 'file',
                'label' => 'Прикрепите файл',
                'size' => '5',
                'format' => 'png,jpg,pdf,docx,xls',
                'sprite' => 'reaction',
                'icon' => 'plus',
                'error' => 'файл не соответсвует требованиям',
            ]) !!}
        </div>

    </div>
    <p class="{{ $block->elem('notice') }}"><span>*</span> поля, обязательные для заполнения</p>
    <div class="{{ $block->elem('bottom') }}">
        <div class="{{ $block->elem('policy') }}">
            {!! $renderer->renderblock('field/checkbox', [
                'name' => 'conditon',
                'required' => true,
                'label' => __('form.policy.internship'),
                'errors' => [__('form.errors.policy')],
            ]) !!}
        </div>
        {!! $renderer->renderBlock('common/button', [
            'type' => 'submit',
            'name' => 'send',
            'text' => 'Отправить',
            'icon' => 'arrow-long',
        ]) !!}
    </div>
</form>
