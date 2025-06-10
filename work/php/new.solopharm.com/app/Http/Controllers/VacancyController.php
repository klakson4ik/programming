<?php

namespace App\Http\Controllers;

use App\Models\Pages\VacancyPage;
use App\Models\Vacancy;
use App\Services\BreadcrumbService;
use App\Services\MetaService;
use App\Services\SocialShareService;
use App\Services\VacancyService;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $vacancyQuery = Vacancy::getItems()->orderBy('title', 'asc');

        $page = VacancyPage::getPage();
        $counts = VacancyService::getCounts(Vacancy::getCached());
        $vacanciesRaw = $vacancyQuery->where('city', 'Санкт-Петербург')->get();
        $vacancies = VacancyService::getByDepartment($vacanciesRaw);

        $data = [
            'asset' => 'vacancy',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'vacancies' => $vacancies,
            'counts' => $counts,
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [[
                    'name' => __('pages.breadcrumbs.vacancy'),
                    'url' => '/'
                ]]
            )
        ];
        return view('vacancy', $data);
    }

    public function getPartial(Request $request)
    {
        $vacancyQuery = Vacancy::getItems()->orderBy('title', 'asc');

        if ($request->city == 'Санкт-Петербург') {
            $vacanciesRaw = $vacancyQuery->where('city', $request->city)->get();
            $vacancies = VacancyService::getByDepartment($vacanciesRaw);
        } else {
            $vacanciesRaw = $vacancyQuery->where('city', '!=', 'Санкт-Петербург')->get();
            $vacancies = VacancyService::getByCity($vacanciesRaw); 
        }

        $data = [
            'city' => $request->city,
            'vacancies' => $vacancies
        ];
        return view('partials.vacancy-list', $data);
    }

    public function show(Request $request)
    {
        if ($vacancy = Vacancy::isActive()->lang()->where('url_slug', $request->route('vacancy'))->first()) {
            $page = VacancyPage::getPage();

            $meta = [
                'title' => $vacancy->title . ' | ' . __('pages.vacancy.meta.title'),
                'description' => __('pages.vacancy.meta.desc-start') . ' - ' .  $vacancy->title . '. ' . __('pages.vacancy.meta.desc'),
                'keywords' => __('pages.vacancy.meta.keywords'),
            ];

            $shares = app()->getLocale() != 'ru'
                ? ['wa', 'telegram', 'ln']
                : ['vk', 'ok', 'telegram', 'wa'];

            $data = [
                'asset' => 'vacancy',
                'meta' => $meta,
                'page' => $page,
                'vacancy' => $vacancy,
                'respond' => 'mailto:' . config('constant.mail.hr') . '?subject=' . __('pages.respond.subject-start') . ' (' . $vacancy->title . ')&body=' . __('pages.respond.body-start') . ' «' . $vacancy->title . '» ' . __('pages.respond.body-end'),
                'socialShare' => SocialShareService::getData($meta, $shares),
                'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                    [
                        [
                            'name' => $vacancy->title,
                            'url' => 'career/vacancy/' . $vacancy->url_slug
                        ],
                    ]
                )
            ];
        } else {
            return abort(404);
        }

        return view('vacancy-item', $data);
    }
}
