<?php

namespace App\Web\User\Models\Category;

class CategoryNestedTree
{
	private $nestedTree = [];
	private $dataDB = [];

	public function __construct()
	{
		$this->dataDB = CategoryDBModel::getDataDB();
		$this->nestedTree = $this->createNestedTree();
	}

	private function createNestedTree()
	{
		$tree = [];
      foreach ($this->dataDB as $id=>&$node) {
      	if ($node['parent_id'] == 0)
         	$tree[$id] = &$node;
        else
            $this->dataDB[$node['parent_id']]['children'][$id] = &$node;
      }  	
      return $tree;
	}

	public function getNestedTree()
	{
		return $this->nestedTree;
	}

}
