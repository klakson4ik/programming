<?php

namespace App\Web\Admin\Models\Category;

use App\Web\Admin\Models\AppModel;
use vendor\core\libs\DB\DBConnector;

class CategoryDBModel extends AppModel
{
	public static function getEditDataDB(int $id) : array
	{
		$db = DBConnector::connect();
		$sql = ("SELECT `id`, `name`, `parent_id` FROM `categories` WHERE `id` = :id");
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();
    $result = $stmt->fetch();
    return $result;
	}

  public static function storeDataDB(array $data) : void
  {
    $db = DBConnector::connect();
    $sql = ("INSERT INTO `categories` (`name`, `parent_id`) VALUES (:name, :parent_id)");
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $data['name'], \PDO::PARAM_STR);
    $stmt->bindValue(':parent_id', $data['parent_id'], \PDO::PARAM_INT);
    $stmt->execute();
  } 

  public static function updateDataDB(int $id, array $data) : void
  {
    $db = DBConnector::connect();
    $sql = ("UPDATE `categories`  SET `name` = :name, `parent_id` = :parent_id WHERE `id` = :id");
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->bindValue(':name', $data['name'], \PDO::PARAM_STR);
    $stmt->bindValue(':parent_id', $data['parent_id'], \PDO::PARAM_INT);
    $stmt->execute();
  } 
  public static function destroyDataDB(int $id) : void
  {
    $db = DBConnector::connect();
    $sql = ("DELETE FROM `categories` WHERE `id` = :id ");
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  } 

}


