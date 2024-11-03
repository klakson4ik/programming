<?php
namespace App\Web\User\Models\Home;

use App\Web\User\Models\AppModel;
use vendor\core\libs\DB\DBConnector;

class HomeDBModel extends AppModel
{
	public static function getDataDB($page, $perpage)
	{
		$db = DBConnector::connect();
    $start = ($page - 1) * $perpage;
		$sql = "SELECT a.id, a.title, a.date_create, i.image_full, i.image_alt
            FROM (SELECT id, title, date_create FROM `articles` ORDER BY date_create DESC LIMIT " . $start . "," . $perpage . ") AS a 
            LEFT JOIN `images` AS i ON a.id = i.articles_id
            GROUP BY a.id ORDER BY a.date_create DESC"; 
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$articles = $stmt->fetchAll(\PDO::FETCH_UNIQUE);
		$sql = ("SELECT COUNT(id) FROM articles"); 
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$countArticles = $stmt->fetchAll();
    $result['articles'] = $articles;
    $result['count'] = $countArticles;

		return $result;
	}
}
