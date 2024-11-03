<?php

namespace App\Web\User\Models\Category;

use App\Web\User\Models\AppModel;
use vendor\core\libs\DB\DBConnector;

class CategoryDBModel extends AppModel
{
	public static function getDataDB()
	{
		$db = DBConnector::connect();
		$sql = ("SELECT `id`, `name`, `alias`, `parent_id` FROM `categories`");
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_UNIQUE);
		return $result;
	}
}
