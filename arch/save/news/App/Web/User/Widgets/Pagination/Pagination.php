<?php


namespace App\Web\User\Widgets\Pagination;

use App\Web\User\Models\Home\HomeModel;

class Pagination
{
    public function getPagination($page, $perpage){
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		    $data = HomeModel::getData($page, $perpage);
        $pagination = new PaginationModel($page, $perpage, $data["articles"], $data["count"]);
        $pages = $data['articles'];
        $paginationView = new PaginationView($pagination->getCurrentPage(), $pagination->getCountPages(), $pagination->getUri());
        $view = $paginationView->getHtml();

        return ['pages' => $pages, 'view' => $view];

    }
}
