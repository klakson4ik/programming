<?php

namespace App\Web\User\Models\News;

use App\Web\User\Models\AppModel;
use vendor\core\libs\DB\DBConnector;

class NewsDBModel extends AppModel
{
	public static function getDataDB($id)
	{
		$db = DBConnector::connect();
		$sql = ("SELECT a.*, i.image_full, i.image_alt
              FROM (SELECT * FROM `articles` WHERE id = :id) AS a 
              LEFT JOIN `images` AS i ON a.id = i.articles_id
              GROUP BY a.id");
		$stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		$article = $stmt->fetch();
    $result['article'] = $article;
		return $result;
	}

	public static function getDataRelatedDB()
	{
		$db = DBConnector::connect();
		$sql = ("SELECT a.id, a.title, i.image_full, i.image_alt
              FROM (SELECT id, title FROM `articles` WHERE date(date_create) = curdate() ORDER BY rand() LIMIT 12) AS a 
              LEFT JOIN `images` AS i ON a.id = i.articles_id
              GROUP BY a.id");
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$articles = $stmt->fetchAll(\PDO:: FETCH_UNIQUE);
    $result['articles'] = $articles;
		return $result;
	}
}
