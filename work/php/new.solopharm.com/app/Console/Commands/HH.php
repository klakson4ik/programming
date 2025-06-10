<?php

namespace App\Console\Commands;

use App\Models\Vacancy;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class HH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:hh';

    private const EMPLOYER_ID = '1228187';
    private const PER_PAGE = '100';
    private const MAIL = 'solopharm@solopharm.com';
    private $vacancies = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get headhunter vacancies';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $list = $this->getCurlData("https://api.hh.ru/vacancies?per_page=" . self::PER_PAGE . "&employer_id=" . self::EMPLOYER_ID);
        $this->getVacancies($list);
        for ($i = 1; $i <= $list->pages; ++$i) {
            $listElse = $this->getCurlData("https://api.hh.ru/vacancies?page=" . $i . "&per_page=" . self::PER_PAGE . "&employer_id=" . self::EMPLOYER_ID);
            $this->getVacancies($listElse);
        }
        $this->createOrUpdate();
    }

    private function getCurlData($url)
    {
        $headers = [
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'User-Agent: Solopharm/1.0 (' . self::MAIL . ')'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode(($output));
    }

    private function getVacancies($data)
    {
        foreach ($data->items as $item) {
            array_push($this->vacancies, $this->getCurlData($item->url));
        }
    }

    private function createOrUpdate()
    {
        $tempTitleArr = [];
        foreach ($this->vacancies as $vacancy) {
            if (!isset($vacancy->name)) {
                continue;
            }
            array_push($tempTitleArr, $vacancy->name);
            $vacancyModel = Vacancy::where('url_slug', $this->createSlug($vacancy->name, $vacancy->area->name ?? 'other'));
            if ($vacancyModel->exists()) {
                $vacancyModel->update(
                    [
                        'city' => $vacancy->area->name ?: 'Другие',
                        'title' => $vacancy->name ?? '',
                        'publish_at' => $vacancy->published_at ?? '',
                    ]
                );
            } else {
                Vacancy::create(
                    [
                        'lang' => 'ru',
                        'city' => $vacancy->area->name ?: 'Другие',
                        'active' => 0,
                        'title' => $vacancy->name ?? '',
                        'url_slug' => $this->createSlug($vacancy->name, $vacancy->area->name ?? 'other'),
                        'description' => $vacancy->description ?? '',
                        'department' => ($vacancy->professional_roles[0]->name) ?: 'Другое',
                        'publish_at' => $vacancy->published_at ?? ''
                    ]
                );
            }
        }
        $vacancyDB = Vacancy::all();
        if ($vacancyDB->count() > count($this->vacancies)) {
            foreach($vacancyDB as $vacancy){
                if(!in_array($vacancy->title, $tempTitleArr)){
                    $vacancy->delete();
                }
            }
        }
    }

    private function createSlug($title, $city)
    {
        return Str::slug($title . '-' . $city, '-');
    }
}
