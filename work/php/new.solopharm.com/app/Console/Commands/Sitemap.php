<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Press;
use App\Models\Product;
use App\Models\Site;
use App\Models\Trade;
use App\Models\Vacancy;
use App\Services\MenuService;
use App\Services\ProductService;
use Illuminate\Console\Command;

class Sitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sitemap';

    private const PUBLIC_PATH  =  APP_PATH . 'public/';
    private const TIMEZONE = 'Europe/Moscow';
    private const LANGS = ['ru', 'en'];
    private const LANDINGS_PAGES = ['products', 'news', 'vacancies', 'gallery'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sitemap';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $this->setTimeZone();
        $this->breeding();
        $this->createSitemaps();
    }

    private function setTimeZone()
    {
        date_default_timezone_set(self::TIMEZONE);
    }

    private function breeding()
    {
        $content = '<sitemapindex>' . PHP_EOL;
        $end = '</sitemapindex>';
        foreach (self::LANGS as $lang) {
            $content .= '<sitemap>' . PHP_EOL
                . '<loc>' . config('app.url') . '/sitemap-' . $lang . '.xml</loc>' . PHP_EOL
                . '<lastmod>' . date('c', time()) .  '</lastmod>' . PHP_EOL
                . '</sitemap>' . PHP_EOL;
        }
        $content .= $end;
        $file = self::PUBLIC_PATH . 'sitemap.xml';
        $this->createFile($file, $content);
    }

    private function createSitemaps()
    {
        foreach (self::LANGS as $lang) {
            $this->createSitemap($lang);
        }
    }

    private function createSitemap($lang)
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL
            . $this->cell(($lang == 'ru' ? '' : $lang), 'always', date('c', time()), '1');

        $menuClass = new MenuService();
        $links = $menuClass->getLinks($lang);

        foreach ($links as $link) {
            $freq = in_array($link['name'], self::LANDINGS_PAGES) ?  'always' : 'daily';
            $priority = in_array($link['name'], self::LANDINGS_PAGES) ?  '0.9' : '0.5';
            $content .= $this->cell(($lang == 'ru' ? '' : $lang . '/') . $link['url'], $freq, date('c', time()), $priority);
        }

        $content .= $this->productBlock($lang);

        $sites = Site::isActive()->lang($lang)->get();
        if (!$sites->isEmpty()) {
            $url = ($lang == 'ru' ? '' : $lang . '/') . 'about/gallery/';
            $content .= $this->setBlocks($sites, $url, 'action');
        }

        $news = News::isActive()->lang($lang)->get();
        if (!$news->isEmpty()) {
            $url = ($lang == 'ru' ? '' : $lang . '/') . 'about/news/';
            $content .= $this->setBlocks($news, $url);
        }

        $press = Press::isActive()->lang($lang)->get();
        if (!$press->isEmpty()) {
            $url = ($lang == 'ru' ? '' : $lang . '/') . 'about/presses/';
            $content .= $this->setBlocks($press, $url);
        }

        $vacancy = Vacancy::isActive()->lang($lang)->get();
        if (!$vacancy->isEmpty()){
            $url = ($lang == 'ru' ? '' : $lang . '/') . 'career/vacancies/';
            $content .= $this->setBlocks($vacancy, $url);
        }

        $content .= '</urlset>';
        $file = self::PUBLIC_PATH . 'sitemap-' . $lang . '.xml';
        $this->createFile($file, $content);
    }


    private function productBlock($lang)
    {
        $content = '';
        $products = Product::isActive()->lang($lang)->get();
        $trades = Trade::isActive()->lang($lang)->sort(['is_main' => 'desc', 'sort' => 'asc'])->get();
        $products = ProductService::getProductsWithTrade($products, $trades);
        $urlRaw = ($lang == 'ru' ? '' : $lang . '/') . 'products/';
        foreach ($products as $product) {
            $url = $urlRaw . $product->url_slug;
            $freq = 'daily';
            $priority = '0.7';
            foreach ($product->trades as $trade) {
                $date = date('c', $trade->updated_at->getTimestamp());
                $finalUrl = $url .  '/' . $trade->url_slug;
                $content .= $this->cell($finalUrl, $freq, $date, $priority);
            }
        }

        return $content;
    }

    private function setBlocks($data, $urlStart, $urlAction = 'url_slug')
    {
        $content = '';
        foreach ($data as $item) {
            $url = $urlStart . $item[$urlAction];
            $freq = 'daily';
            $priority = '0.7';
            $date = date('c', $item->updated_at->getTimestamp());
            $content .= $this->cell($url, $freq, $date, $priority);
        }

        return $content;
    }

    private function cell($url, $freq, $date, $priority)
    {
        return  '<url>' . PHP_EOL
            . '<loc>' . config('app.url') . '/' . $url . '</loc>' . PHP_EOL
            . '<changefreq>' . $freq . '</changefreq>' . PHP_EOL
            . '<lastmod>' . $date . '</lastmod>' . PHP_EOL
            . '<priority>' . $priority . '</priority>' . PHP_EOL
            . '</url>' . PHP_EOL;
    }

    private function createFile($file, $content)
    {
        $fp = fopen($file, "w");
        fwrite($fp, $content);
        fclose($fp);
    }
}
