<?php

namespace App\Web\Admin\Controllers;

use App\Web\Admin\Controllers\AppController;
use App\Web\Admin\Models\Category\CategoryIndexModel;
use App\Web\Admin\Models\Category\CategoryStoreModel;
use App\Web\Admin\Models\Category\CategoryDestroyModel;
use App\Web\Admin\Models\Category\CategoryEditModel;
use App\Web\Admin\Models\Category\CategoryUpdateModel;

class CategoryController extends AppController
{

  private const REDIRECT_ROUTE = '/admin/category';
  private const SESSION_FLAG = 'category_update'; 

	public function index() : void
	{
		$data = CategoryIndexModel::getData();
		$this->setData($data);
	}

	public function create() :void
	{
    $parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0;
    $this->setData($parent_id);  
	}

	public function store() : void
	{
    $data = $_POST;
    CategoryStoreModel::storeData($data);
    $_SESSION[self::SESSION_FLAG] = true;
    redirect(self::REDIRECT_ROUTE);
	}

	public function edit() : void
	{
    $id = $this->route['id'];
    $data = CategoryEditModel::getEditData($id);
    if(empty($data))
    {
      redirect(self::REDIRECT_ROUTE);
    }
    $this->setData($data);  
	}

	public function update() : void
	{
    $id = $this->route['id'];
    $data = $_POST;
    CategoryUpdateModel::updateData($id, $data);
    $_SESSION[self::SESSION_FLAG] = true;
    redirect(self::REDIRECT_ROUTE);
	}

	public function destroy() : void
	{
    $id = $this->route['id'];
    CategoryDestroyModel::destroyData($id);
    $_SESSION[self::SESSION_FLAG] = true;
    redirect(self::REDIRECT_ROUTE);
	}
}
