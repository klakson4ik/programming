<?php

namespace App\Web\User\Models\Category;

use App\Web\User\Models\AppModel;

class CategoryModel extends AppModel
{
	private $nestedTree;
  private $data;
  private $tpl;

	public function __construct($tpl)
  {
    $this->tpl = $tpl;
		$this->nestedTree = $this->getNestedTree();
		$this->data = $this->createHtml();
	}

	private function getNestedTree()
	{
		  $nestedTree = new CategoryNestedTree();
		  return $nestedTree->getNestedTree();
 
	}

	private function createHtml()
	{
		  $template = new CategoryTemplate($this->nestedTree, $this->tpl);
		  return $template->getHtml();
	}

	public function getData()
	{
		return $this->data;
	}
}
