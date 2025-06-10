<?php

namespace App\Http\Controllers;

use App\Services\BreadcrumbService;
use App\Services\MailService;
use Illuminate\Http\Request;

class AdverseReactionController extends Controller
{
    public function index(Request $request)
    {
        $page = [
            'title' => 'Сообщить о нежелательной реакции',
        ];

        $data = [
            'asset' => 'adverse-reaction',
            'form' => $request->route()->getName(),
            'page' => $page,
            'meta' => [
                'title' => 'Сообщить о нежелательной реакции при применении продукции Solopharma',
                'description' => 'Компания ООО «Гротекс» уделяет особое внимание безопасности выпускаемых лекарственных препаратов и медицинских изделий. Сообщить информацию или задать интересующие вопросы по безопасности Вы можете прямо на нашем сайте, заполнив форму, или любым другим удобным способом'
            ],
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [
                    [
                        'name' => $page['title'],
                        'url' => 'policy'
                    ],
                ]
            )
        ];

        return view('adverse-reaction', $data);
    }

    public function storePatient(Request $request)
    {
        $file = MailService::getFile($_FILES['file']);
        $who = $request->who == 'Другой' ? $request->who . ' - ' . $request->other_name : $request->who;
        $subject = 'Сообщение о нежелательной реакции: ' . $who;
        $message = MailService::getBody(
            [
                '<b>Кем вы являетесь:</b> ' . $who,
                '<b>ФИО:</b> ' . $request->fio,
                $request->fio_patient ? '<b>ФИО пациента:</b> ' . $request->fio_patient : '',
                '<b>Возраст:</b> ' . ($request->age_patient == null ? $request->age : $request->age_patient),
                '<b>Пол:</b> ' . $request->gender,
                '<b>Телефон:</b> +7' . $request->phone,
                '<b>E-mail:</b> ' . $request->email,
                '<b>Название лекарственного средства:</b> ' . $request->product,
                '<b>Производитель:</b> ' . $request->manufacturer,
                '<b>Серия:</b> ' . $request->series,
                '<b>Описание случая:</b>' . $request->case,
            ],
            $subject
        );
        $this->send($request, $file, $message, $subject);
        return back()->with('status', 'send');
    }

    public function storeMedical(Request $request)
    {
        $file = MailService::getFile($_FILES['file']);
        $subject = 'Сообщение о нежелательной реакции: Медицинский работник';
        $message = MailService::getBody(
            array_merge(
                [
                    '<h2>Данные пациента</h2>',
                    '<b>Инициалы пациента:</b> ' . $request->name,
                    '<b>Пол:</b> ' . $request->gender,
                    '<b>Вес:</b> ' . $request->weight . ' кг.',
                    '<b>Беременность:</b> ' . (($request->pregnant == 'Есть, срок в неделях') ? $request->pregnant . ' - ' . $request->pregnant_term : $request->pregnant),
                    '<b>Аллергия:</b> ' . (($request->allergy == 'Есть, на') ? $request->allergy . ' - ' . $request->allergy_on : $request->allergy),
                    '<b>Лечение:</b> ' . $request->treatmen
                ],
                $this->getDrugs($request, 'suspect', '<h2>Подозреваемые лекарственные  средства / медицинские изделия</h2>'),
                [
                    '<h2>Нежелательная реакция</h2>',
                    '<b>Дата начала нежелательной реакции:</b> ' . $request->data_start_adverse_reaction,
                    '<b>Описание реакции:</b> ' . $request->desc_reaction,
                    '<b>Критерии серьезности нежелательной реакции:</b> ' . $request->adverse_reaction_criteria,
                    '<b>Дата разрешения нежелательной реакции:</b> ' . $request->data_adverse_reaction_resalution,
                    '<h2>Предпринятые меры</h2>',
                    $request->measures_taken == 'Лекарственная терапия' ? $request->measures_taken . ' - ' . $request->drug_therapy_desc : $request->measures_taken,
                    '<h2>Исход</h2>',
                    $request->outcome == 'Выздоровление с последствиями (указать)' ? $request->outcome . ' - ' . $request->recovery_with_consequences_desc : $request->outcome,
                    '<h2>Сопровождалась ли отмена лекарственного средства /медицинского изделия исчезновением нежелательной реакции?</h2>',
                    $request->cancel_adverse_reaction,
                    '<h2>Назначалось ли лекарственное средство / медицинское изделие повторно?</h2>',
                    $request->repeat_drug == 'Да, результат' ? $request->repeat_drug . ' - ' . $request->yes_result : $request->repeat_drug
                ],
                $this->getDrugs($request, 'other', '<h2>Другие лекарственные средства, принимаемые в течение последних 3 месяцев, включая лекарственные средства, принимаемые пациентом самостоятельно (по собственному желанию)</h2>', $request->other_drugs),
                [
                    '<h2>Данные репортера</h2>',
                    $request->reporter,
                    '<b>ФИО:</b> ' . $request->fio,
                    '<b>Должность и место работы:</b> ' . $request->position,
                    '<b>Дата обращения:</b> ' . $request->date,
                    '<b>Телефон:</b> +7' . $request->phone,
                    '<b>E-mail:</b> ' . $request->email,
                ]
            ),
            $subject
        );
        $this->send($request, $file, $message, $subject);
        return back()->with('status', 'send');
    }

    private function send($request, $file, $message, $subject)
    {
        if (!$file) {
            $headers = MailService::getHeaders($request->email, $request->name);
            $body = $message;
        } else {
            $headers = MailService::getHeaders($request->email, $request->name, true);
            $body = MailService::getMixedBody($message, $file);
        }
        mail(env('MAIL_ADVERSE_REACTION'), $subject, $body, $headers);
    }

    private function getDrugs($request, $section, $title, $adds = false)
    {
        $array = [];
        array_push($array, $title);
        if ($adds) {
            array_push($array, $adds);
        }
        for ($i = 1; $i <= $request->{$section . '_count'}; ++$i) {
            $array = array_merge($array, [
                '<u>Препарат №' .   $i . '</u>',
                '<b>Наименование лекарственного средства:</b> ' . $request->{'suspect_drug_' . $i},
                '<b>Производитель:</b> ' . $request->{'suspect_manufacturer_' . $i},
                '<b>Номер серии:</b> ' . $request->{'suspect_series_' . $i},
                '<b>Доза, путь введения:</b> ' . $request->{'suspect_dose_' . $i},
                '<b>Дата начала терапии:</b> ' . $request->{'suspect_start_data_therapy_' . $i},
                '<b>Дата окончания терапии:</b> ' . $request->{'suspect_end_data_therapy_' . $i},
                '<b>Показание:</b> ' . $request->{'suspect_indications_' . $i},
            ]);
        }
        return $array;
    }
}
