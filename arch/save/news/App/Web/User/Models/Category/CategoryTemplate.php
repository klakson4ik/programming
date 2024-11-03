<?php
	
namespace App\Web\User\Models\Category;

class CategoryTemplate
{
	private $nestedTree;
	private $html;
	private $tpl;
	private $count = 0;

	public function __construct($data, $tpl)
	{
    $this->tpl = $tpl;
		$this->nestedTree = $data;
		$this->html = $this->createHtml();
	}
	
	private function createHtml()
	{
    ob_start();
		$html = '';
		foreach($this->nestedTree as $key=>$branch)
		{
			$html .= $this->createBranch($branch, $key);
    }

    $result = ob_get_contents();
    ob_end_clean();
		return $result;
	}


   private function createBranch($branch, $key)
   {
     require $this->tpl;
   }

	public function getHtml()
	{
		  return $this->html;		
	}
}
