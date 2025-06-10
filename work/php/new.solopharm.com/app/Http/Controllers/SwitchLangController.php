<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class SwitchLangController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * 
     */

    private $request;


    public function __invoke(Request $request)
    {
        $this->request = $request;
        if ($request->lang && in_array($request->lang, config('app.available_locales'))) {
            Cookie::queue('locale', $request->lang, 365 * 24 * 60);
        }

        $url = $this->getRedirectUrl();
        return redirect($url);
    }

    private function getRedirectUrl()
    {
        $url = '';
        $urlDetail = '/';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $urlArr = explode('/', ltrim(str_replace($_SERVER['APP_URL'], '', $_SERVER['HTTP_REFERER']), '/'));
            if ($this->request->lang == 'ru') {
                $url = isset($urlArr[1]) ? $urlArr[1] : '';
                $urlDetail = $this->consistUrl($url, $urlArr, 2);
            } else {
                $url = isset($urlArr[0]) ? $urlArr[0] : '';
                $urlDetail = $this->consistUrl($url, $urlArr, 1);
            }
            if ($url == 'suppliers') {
                return '/';
            }

            if ($url == 'products') {
                return '/' . $url;
            }
            $newsUrl = explode('/', $urlDetail);
            if (isset($newsUrl[1]) && ($newsUrl[1] == 'news' || $newsUrl[1] == 'presses')) {
                return '/' . $url . '/' . $newsUrl[1];
            }
        }
        return $urlDetail;
    }

    private function consistUrl($url, $array, $offset)
    {
        $arrayLength = count($array);
        $newUrl = $url;
        for ($i = $offset; $i < $arrayLength; ++$i) {
            $newUrl .= '/' . $array[$i];
        }

        return $newUrl;
    }

    private function isPageAvailible($page)
    {
        //проверка на валидность урла
        $page = $_SERVER['APP_URL'] . $page;
        if (!filter_var($page, FILTER_VALIDATE_URL)) {
            return false;
        }

        //инициализация curl
        $curlInit = curl_init($page);
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curlInit, CURLOPT_HEADER, true);
        curl_setopt($curlInit, CURLOPT_NOBODY, true);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlInit, CURLOPT_HTTPHEADER, ['Accept-Language: ' . $this->request->lang]);
        //получение ответа
        curl_exec($curlInit);
        $response = curl_getinfo($curlInit,);
        curl_close($curlInit);
        if ($response == 200) return true;
        return false;
    }
}
