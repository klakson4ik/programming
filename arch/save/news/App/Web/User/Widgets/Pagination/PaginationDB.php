<?php


namespace App\Web\User\Widgets\Pagination;


use vendor\core\libs\DB;

class PaginationDB
{
    public static function getTotalDB($IDs){
        $sql = ("SELECT COUNT(1) FROM articles WHERE category_id = ?");
        return DB::getArrayCategory($sql, $IDs);
    }
}
