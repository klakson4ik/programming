<section class="{{ $block }}">
    <div class="{{ $block->elem('desc') }}">
        <p>Компания ООО «Гротекс» уделяет особое внимание безопасности выпускаемых лекарственных препаратов и
            медицинских изделий.</p><br />
        <p>С этой целью в компании осуществляется сбор, регистрация и обработка всех обращений, связанных c
            возникновением нежелательных реакций, отсутствием эффективности и иными случаями при применении продукции
            Solopharm.</p><br />
        <p>Сообщить информацию или задать интересующие вопросы по безопасности Вы можете:</p>
        <ul class="{{ $block->elem('list') }}">
            <li>позвонив по бесплатному телефону «горячей» линии <a href="tel:+78007000473"
                    class="{{ $block->elem('desc-tel') }}">8-800-700-04-73</a>. В нерабочее время, выходные,
                праздничные дни в случае отсутствия специалистов на месте, воспользуйтесь, пожалуйста, функцией
                автоответчика;</li>
            <li>отправив письмо на электронную почту <a href="mailto:{{ config('constant.mail.adverse-reaction') }}"
                    class="{{ $block->elem('desc-link') }}">{{ config('constant.mail.adverse-reaction') }}</a>;</li>
            <li>заполнив форму ниже.</li>
        </ul><br />
        <p>Обращаем Ваше внимание, что передавая информацию любым вышеуказанным способом, Вы даете согласие на ее
            обработку
            компанией ООО «Гротекс» в соответствии с <a class="{{ $block->elem('desc-policy') }}" href="/policy"
                target="_blank">политикой конфиденциальности</a>.
        </p>
    </div>
    <nav class="{{ $block->elem('menu') }}">
        <ul class="{{ $block->elem('menu-list') }}">
            <li class="{{ $block->elem('menu-item')->mod($form == 'reaction-patient' ? 'active' : '') }}">

                <a href="/adverse-reaction-patient" class="{{ $block->elem('menu-link') }}">
                    {!! $renderer->renderBlock('common/icon', [
                        'icon' => 'patient',
                        'sprite' => 'reaction',
                    ]) !!}
                    Пациент</a>
            </li>
            <li class="{{ $block->elem('menu-item')->mod($form == 'reaction-medical' ? 'active' : '') }}">
                <a href="/adverse-reaction-medical" class="{{ $block->elem('menu-link') }}">
                    {!! $renderer->renderBlock('common/icon', [
                        'icon' => 'medical',
                        'sprite' => 'reaction',
                    ]) !!}
                    Медицинский работник</a>
            </li>
        </ul>
    </nav>
</section>
