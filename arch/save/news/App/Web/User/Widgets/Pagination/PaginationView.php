<?php


namespace App\Web\User\Widgets\Pagination;


class PaginationView
{
    private $currentPage;
    private $countPages;
    private $uri;


    public function __construct($currentPage, $countPages, $uri)
    {
        $this->currentPage = $currentPage;
        $this->countPages = $countPages;
        $this->uri = $uri;
    }


    public function getHtml(){
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        if( $this->currentPage > 1 ){
            $back = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage - 1). "'>&lt;</a></li>";
        }

        if( $this->currentPage < $this->countPages ){
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>&gt;</a></li>";
        }

        if( $this->currentPage > 3 ){
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        if( $this->currentPage < ($this->countPages - 2) ){
            $endpage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }
        if( $this->currentPage - 2 > 0 ){
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-2). "'>" .($this->currentPage - 2). "</a></li>";
        }
        if( $this->currentPage - 1 > 0 ){
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-1). "'>" .($this->currentPage-1). "</a></li>";
        }
        if( $this->currentPage + 1 <= $this->countPages ){
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>" .($this->currentPage+1). "</a></li>";
        }
        if( $this->currentPage + 2 <= $this->countPages ){
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 2). "'>" .($this->currentPage + 2). "</a></li>";
        }

        return '<ul class="pagination">' . $startpage.$back.$page2left.$page1left.'<li><a class="nav-link active">'.$this->currentPage.'</a></li>'.$page1right.$page2right.$forward.$endpage . '</ul>';
    }

//        public function __toString(){
//        return $this->getHtml();
//    }
}
