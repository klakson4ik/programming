<?php

namespace App\Web\User\Models\CreatePost;

use App\Web\User\Models\AppModel;
use vendor\core\libs\DB\DBConnector;

class CreatePostDBModel extends AppModel
{
	public static function getDataDB()
	{
		$db = DBConnector::connect();
		$sql = ("SELECT * FROM ``");
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
}
