<form class="{{ $block }}" id="reaction-medical" name="reaction-medical" method="post"
    action="/{{ request()->path() }}" enctype="multipart/form-data">
    @csrf
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/patient-data', [
            'title' => 'Данные пациента',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/suspect-drug', [
            'title' => 'Подозреваемые лекарственные  средства / медицинские изделия',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/adverse-reaction', [
            'title' => 'Нежелательная реакция',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/measures-taken', [
            'title' => 'Предпринятые меры',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/outcome', [
            'title' => 'Исход',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/cancel-reaction', [
            'title' =>
                'Сопровождалась ли отмена лекарственного средства / медицинского изделия исчезновением нежелательной реакции?',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/repeat-drugs', [
            'title' => 'Назначалось ли лекарственное средство / медицинское изделие повторно?',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/other-drugs', [
            'title' =>
                'Другие лекарственные средства, принимаемые в течение последних 3 месяцев, включая лекарственные средства, принимаемые пациентом самостоятельно (по собственному желанию)',
        ]) !!}
    </div>
    <div class="{{ $block->elem('fields') }}">
        {!! $renderer->renderblock('form/reaction-medical/reporter', [
            'title' => 'Данные репортера',
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
