<form class="{{ $block }}" id="supplier" name="supplier" method="post" action="/{{ request()->path() }}">
    {{-- <p class="{{ $block->elem('info') }}">{!! __('form.supplier.info') !!}</p> --}}
    @csrf
    <div class="{{ $block->elem('policy') }}">
        {{-- {!! $renderer->renderblock('field/checkbox', [
            'name' => 'policy',
            'label' => __('form.supplier.policy'),
            'required' => true,
            'errors' => [__('form.errors.policy')],
        ]) !!} --}}

        {!! $renderer->renderblock('field/checkbox', [
            'name' => 'conditon',
            'required' => true,
            'label' => __('form.policy.internship'),
            'errors' => [__('form.errors.policy')],
        ]) !!}
    </div>
    <div class="{{ $block->elem('condition') }}">

    </div>

    <p class={{ $block->elem('subtitle') }}>{!! __('form.supplier.questionnaire') !!}</p>
    <div class="{{ $block->elem('radio') }}">
        {!! $renderer->renderblock('field/radio', [
            'caption' => __('form.supplier.grotex'),
            'name' => 'sup_grotex',
            'fields' => [
                [
                    'name' => 'yes',
                    'label' => __('form.supplier.yes'),
                ],
                [
                    'name' => 'no',
                    'label' => __('form.supplier.no'),
                ],
            ],
        ]) !!}
    </div>
    <div class="{{ $block->elem('radio') }}">
        {!! $renderer->renderblock('field/radio', [
            'caption' => __('form.supplier.resident'),
            'name' => 'resident',
            'fields' => [
                [
                    'name' => 'yes',
                    'label' => __('form.supplier.yes'),
                ],
                [
                    'name' => 'no',
                    'label' => __('form.supplier.no'),
                ],
            ],
        ]) !!}
    </div>
    <div class="{{ $block->elem('textarea') }}">
        {!! $renderer->renderblock('field/textarea', [
            'name' => 'supply_cat',
            'label' => __('form.supplier.supply-cat'),
            'rows' => '4',
            'required' => true,
        ]) !!}
    </div>

    {{-- <p class={{ $block->elem('subtitle') }}>{!! __('form.supplier.subtitle-name') !!}</p> --}}
    <div class="{{ $block->elem('fields') }}">
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderblock('field/input', [
                'name' => 'company',
                'label' => __('form.supplier.company'),
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/select', [
                'name' => 'type_company',
                'label' => __('form.supplier.type-company.name'),
                'options' => [__('form.supplier.type-company.manufacturer'), __('form.supplier.type-company.distributor'), __('form.supplier.type-company.service')],
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'INN',
                'label' => __('form.supplier.INN'),
                'pattern' => '^\d{10}$',
                'required' => true,
                'errors' => [
                    'error' => __('form.errors.INN'),
                ],
                'placeholder' => '1234567890',
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'legal_address',
                'label' => __('form.supplier.legal-address'),
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'actual_address',
                'label' => __('form.supplier.actual-address'),
                'required' => true,
            ]) !!}
        </div>
    </div>
    <div class="{{ $block->elem('field') }}">
        {!! $renderer->renderBlock('field/textarea', [
            'name' => 'system_quality',
            'label' => __('form.supplier.system-quality'),
            'rows' => '4',
            'required' => true,
        ]) !!}
    </div>
    <p class={{ $block->elem('subtitle') }}>{!! __('form.supplier.contact') !!}</p>
    <div class="{{ $block->elem('fields')->mod('last') }}">
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderblock('field/input', [
                'name' => 'person',
                'label' => __('form.supplier.person'),
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'name' => 'job',
                'label' => __('form.supplier.job'),
                'required' => true,
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'type' => 'email',
                'name' => 'email',
                'required' => true,
                'label' => __('form.email'),
                'pattern' => '^[\w\-.]+@([\w-]+\.)+[\w-]{2,4}$',
                'errors' => [
                    'error' => __('form.errors.email'),
                ],
                'placeholder' => 'example@mail.com',
            ]) !!}
        </div>
        <div class="{{ $block->elem('field') }}">
            {!! $renderer->renderBlock('field/input', [
                'type' => 'tel',
                'name' => 'phone',
                'label' => __('form.phone'),
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
                'type' => 'tel',
                'name' => 'work_phone',
                'required' => true,
                'label' => __('form.supplier.work-phone'),
                'pattern' => '^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$',
                'errors' => [
                    'error' => __('form.errors.phone'),
                ],
            
                'placeholder' => '+7 (999) 999-99-99',
            ]) !!}
        </div>
    </div>
    <div class="{{ $block->elem('btn') }}">
        <p class="{{ $block->elem('error') }}">
            {!! __('form.errors.form') !!}
        </p>
        {!! $renderer->renderBlock('common/button', [
            'type' => 'submit',
            'name' => 'send',
            'text' => __('form.btn.send-supplier'),
            'icon' => 'arrow-long',
        ]) !!}
    </div>
</form>
@if (session('status'))
    {!! $renderer->renderBlock('/partials/popup', [
        'header' => __('pages.mail.supplier.subject'),
        'content' => __('form.supplier.success'),
    ]) !!}
@endif
