<?php


namespace App\Web\User\Widgets\Pagination;


class PaginationModel
{
    private $currentPage;
    private $perpage;
    private $total;
    private $countPages;
    private $uri;
    private $start;

    public function __construct($page, $perpage, $array, $count){
        $this->perpage = $perpage;
        $this->total = $count[0]["COUNT(id)"];
        $this->countPages = $this->getOfCountPages();
        $this->currentPage = $this->getOfCurrentPage($page);
        $this->uri = $this->getParams();
        $this->start = $this->getStart();
    }


    private function getOfCountPages(){
        return ceil($this->total / $this->perpage) ?: 1;
    }

    private function getOfCurrentPage($page){
        if(!$page || $page < 1) $page = 1;
        if($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    private function getStart(){
        return ($this->currentPage - 1) * $this->perpage;
    }

    private function getParams(){
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';
        if(isset($url[1]) && $url[1] != ''){
            $params = explode('&', $url[1]);
            foreach($params as $param){
                if(!preg_match("#page=#", $param)) $uri .= "{$param}&amp;";
            }
        }
        return $uri;
    }

    public function getPage($array){
        return array_slice($array, $this->start, $this->perpage);

    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getCountPages()
    {
        return $this->countPages;
    }


    public function getUri()
    {
        return $this->uri;
    }

}
