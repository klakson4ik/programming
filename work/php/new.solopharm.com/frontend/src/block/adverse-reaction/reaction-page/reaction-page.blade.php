<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page['title'] !!}</h1>
    {!! $renderer->renderBlock('adverse-reaction/reaction-text', [
        'form' => $form
    ]) !!}
    @if ($form == 'reaction-patient')
        {!! $renderer->renderBlock('form/reaction-patient') !!}
    @endif
    @if ($form == 'reaction-medical')
        {!! $renderer->renderBlock('form/reaction-medical') !!}
    @endif
    @if (session('status') && locale() == '')
        {!! $renderer->renderBlock('/partials/popup', [
            'header' => 'Сообщение о нежелательной реакции',
            'content' => 'Спасибо! Сообщение успешно отправлено',
        ]) !!}
    @endif
</div>