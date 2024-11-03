<?php

namespace vendor\core\libs\Console\Element;
use vendor\core\libs\Console\Filer;

class ResourceElement
{
	private const MODEL_DB = 'DBModel.php';
	private static $name;

	public static function resource($name){
		self::$name = ucfirst($name);
		self::createController();
		self::createModels();
		self::createViews();
		self::createCSSs();
		self::createJSs();
		self::createRoute();
	}

	private static function createModels(){
		$modelPath = ADMIN . MODELS . '/' .  self::$name;
		if(Filer::createDir($modelPath)){
			self::indexModel();
//			self::createModel();
			self::storeModel();
			self::editModel();
			self::deleteModel();
			self::DBModel();
		}
	}

	private static function createViews(){
		$viewPath = ADMIN . PAGES . '/' . self::$name;
    $createViewPath = $viewPath . '/Create'; 
    $editViewPath = $viewPath . '/Edit'; 
    $indexViewPath = $viewPath . '/Index'; 
		if(Filer::createDir($viewPath)){
		  if(Filer::createDir($indexViewPath)){
			  self::indexView();
      }
		  if(Filer::createDir($createViewPath)){
			  self::createView();
      }
		  if(Filer::createDir($editViewPath)){
			  self::editView();
      }
		}
	}

	private static function createCSSs(){
		$CSSPath = ADMIN . PAGES . '/' . self::$name;
    $createCSSPath = $CSSPath . '/Create'; 
    $editCSSPath = $CSSPath . '/Edit'; 
    $indexCSSPath = $CSSPath . '/Index'; 
		if(is_dir($CSSPath)){
		  if(is_dir($indexCSSPath)){
			  self::indexCSS();
      }
		  if(is_dir($createCSSPath)){
			  self::createCSS();
      }
		  if(is_dir($editCSSPath)){
			  self::editCSS();
      }
			self::importCSS();
			
		}
	}

	private static function createJSs(){
		$JSPath = ADMIN . PAGES . '/' . self::$name;
    $createJSPath = $JSPath . '/Create'; 
    $editJSPath = $JSPath . '/Edit'; 
    $indexJSPath = $JSPath . '/Index'; 
		if(is_dir($JSPath)){
		  if(is_dir($indexJSPath)){
			  self::indexJS();
      }
		  if(is_dir($createJSPath)){
			  self::createJS();
      }
		  if(is_dir($editJSPath)){
			  self::editJS();
      }
		}
	}

  private static function createControllerActions()
  {
    $text = self::indexAction();
    $text .= self::storeAction();
    $text .= self::editAction();
    $text .= self::updateAction();
    $text .= self::destroyAction();
    return $text;
  }

  private static function createDBActions()
  {
    $text = self::indexDB();
    $text .= self::storeDB();
    $text .= self::editDB();
    $text .= self::updateDB();
    $text .= self::destroyDB();
    return $text;
  }
	
	private static function createController(){
		$fileName = self::$name . 'Controller.php';
		$fullName = ADMIN . CONTROLLERS . '/' . $fileName;
    $text ="<?php" . PHP_EOL;
    $text .= PHP_EOL;
    $text .= "namespace App\\Web\\Admin\\Controllers;" . PHP_EOL;
    $text .= PHP_EOL;
    $text .= "use App\\Web\\Admin\\Models\\" . self::$name . "\\" . self::$name . "IndexModel;" . PHP_EOL;
    $text .= "use App\\Web\\Admin\\Models\\" . self::$name . "\\" . self::$name . "StoreModel;" . PHP_EOL;
    $text .= "use App\\Web\\Admin\\Models\\" . self::$name . "\\" . self::$name . "EditModel;" . PHP_EOL;
    $text .= "use App\\Web\\Admin\\Models\\" . self::$name . "\\" . self::$name . "UpdateModel;" . PHP_EOL;
    $text .= "use App\\Web\\Admin\\Models\\" . self::$name . "\\" . self::$name . "DestroyModel;" . PHP_EOL;
    $text .= PHP_EOL;
    $text .= "class " . self::$name . "Controller extends AppController" . PHP_EOL;
    $text .= "{" . PHP_EOL;
    $text .= '  private const REDIRECT_ROUTE = \'/admin/' . lcfirst(self::$name) . '\';' . PHP_EOL;
    $text .= PHP_EOL;
    $text .= self::createControllerActions();

		Filer::createFile($fullName, $text);
  }
    
  private static function indexAction()
  {
    $text .= "public function index() : void" . PHP_EOL;
	  $text .= "{" . PHP_EOL;
		$text .= '  $data = ' . self::$name . 'IndexModel::getData();' . PHP_EOL;
		$text .= '  $this->setData($data);' . PHP_EOL;
    $text .= "}" . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }
  
  private static function createAction(){
	  $text = 'public function create() : void' . PHP_EOL;
	  $text .= '{' . PHP_EOL;
    $text .= PHP_EOL;
    $text .= '}' . PHP_EOL;
    return $text;
  }

  private static function storeAction(){
	  $text = 'public function store() : void' . PHP_EOL;
	  $text .= '{' . PHP_EOL;
    $text .= '  $data = $_POST;' . PHP_EOL;
    $text .= '  ' . self::$name .'StoreModel::storeData($data);' . PHP_EOL;
    $text .= '  redirect(self::REDIRECT_ROUTE);' . PHP_EOL;
	  $text .= '}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
	}

  private static function editAction(){
	  $text = 'public function edit() : void' . PHP_EOL;
	  $text .= '{' . PHP_EOL;
    $text .= '  $id = $this->route[\'id\'];' . PHP_EOL;
    $text .= '  $data = ' . self::$name . 'EditModel::getEditData($id);' . PHP_EOL;
    $text .= '  if(empty($data))' . PHP_EOL;
    $text .= '  {' . PHP_EOL;
    $text .= '    redirect(self::REDIRECT_ROUTE);' . PHP_EOL;
    $text .= '  }' . PHP_EOL;
    $text .= '  $this->setData($data);' . PHP_EOL;  
    $text .= '}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }

  private static function updateAction(){
	  $text = 'public function update() : void' . PHP_EOL;
	  $text .= '{' . PHP_EOL;
    $text .= '  $id = $this->route[\'id\'];' . PHP_EOL;
    $text .= '  $data = $_POST;' . PHP_EOL;
    $text .= '  ' . self::$name . 'UpdateModel::updateData($id, $data);' . PHP_EOL;
    $text .= '  redirect(self::REDIRECT_ROUTE);' . PHP_EOL;
	  $text .= '}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }
  
  private static function destroyAction(){
	  $text = 'public function destroy() : void' . PHP_EOL;
	  $text .= '{' . PHP_EOL;
    $text .= '  $id = $this->route[\'id\'];' . PHP_EOL;
    $text .= '  ' . self::$name . 'DestroyModel::destroyData($id);' . PHP_EOL;
    $text .= '  redirect(self::REDIRECT_ROUTE);' . PHP_EOL;
    $text .= '}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  } 
	
	private static function modelTemplate($model, $modelAction){
    $className = self::$name . $model . "Model";
		$fileName = $className .  '.php';
		$fullName = ADMIN . MODELS . '/' . self::$name . '/' . $fileName;
		$text = '<?php' . PHP_EOL;
		$text .= PHP_EOL;
		$text .= 'namespace App\\Web\\Admin\\Models\\' . self::$name . ';' . PHP_EOL;
		$text .= PHP_EOL;
		$text .= 'use App\\Web\\Admin\\Models\\AppModel;' . PHP_EOL;
		$text .= PHP_EOL;
		$text .= 'class ' . $className .  ' extends AppModel' . PHP_EOL;
		$text .= '{' . PHP_EOL;
		$text .= $modelAction;
		$text .= '}' . PHP_EOL;

		Filer::createFile($fullName, $text);
	}

  private static function indexModel(){
		$text = '	public static function getData() : array' . PHP_EOL;
		$text .= '	{' . PHP_EOL;
		$text .= '		$dataDB = DBModel::getDataDB();' . PHP_EOL;
		$text .= '		return $dataDB;' . PHP_EOL;
		$text .= '	}' . PHP_EOL;
    self::modelTemplate("Index", $text);
  }

  private static function createModel(){
      $text = PHP_EOL;
      self::modelTemplate("Create", $text);
  }

	private static function storeModel(){
    $text = ' public static function storeData(array $data) : void' . PHP_EOL;
    $text .= '{' . PHP_EOL;
    $text .= '//  $data = trim($data);' . PHP_EOL;
    $text .= '  ' . self::$name . 'DBModel::storeDataDB($data);' . PHP_EOL;
    $text .= '}' . PHP_EOL;
		$text .= PHP_EOL;
    self::modelTemplate("Store", $text);
	}

	private static function editModel(){
    $text = ' public static function getEditData(int $id) : array' . PHP_EOL;
    $text .= '{' . PHP_EOL;
    $text .= '  $data[\'' . lcfirst(self::$name) . '\'] = ' . self::$name .  'DBModel::storeDataDB($id);' . PHP_EOL;
    $text .= '  if(empty($data[\'' . self::$name . '\']))' . PHP_EOL;
    $text .= '    return [];' . PHP_EOL;
    $text .= '  return $data;' . PHP_EOL;
    $text .= '}' .PHP_EOL;
		$text .= PHP_EOL;
    self::modelTemplate("Edit", $text);
	}

	private static function updateModel(){
    $text = ' public static function updateData(int $id, array $data) : void' . PHP_EOL;
    $text .= '{' . PHP_EOL;
    $text .= '//  $data = trim($data);' . PHP_EOL;
    $text .= '  ' . self::$name . 'DBModel::updateDataDB($id, $data);' . PHP_EOL;
    $text .= '}' . PHP_EOL;
		$text .= PHP_EOL;
    self::modelTemplate("Update", $text);

	}

	private static function deleteModel(){
    $text = ' public static function destroyData(int $id) : void' . PHP_EOL;
    $text .= '{' . PHP_EOL;
    $text .= '  ' . self::$name . 'DBModel::destroyDataDB($id);' . PHP_EOL;
    $text .= '}' . PHP_EOL;
		$text .= PHP_EOL;
    self::modelTemplate("Delete", $text);
	}

	private static function DBModel(){
    $className = self::$name . 'DBModel';
		$fileName = $className .  '.php';
		$fullName = ADMIN . MODELS . '/' . self::$name . '/' . $fileName;
		$text = '<?php' . PHP_EOL;
		$text .= '' . PHP_EOL;
		$text .= 'namespace App\\Web\\User\\Models\\' . self::$name . ';'. PHP_EOL;
		$text .= '' . PHP_EOL;
		$text .= 'use App\\Web\\User\\Models\\AppModel;' . PHP_EOL;
		$text .= 'use vendor\\core\\libs\\DBConnector;' . PHP_EOL;
		$text .= '' . PHP_EOL;
		$text .= 'class ' . $className . ' extends AppModel' . PHP_EOL;
		$text .= '{' . PHP_EOL;
		$text .= self::createDBActions();
		$text .= '}' . PHP_EOL;

		Filer::createFile($fullName, $text);
	}

  private static function indexDB(){
		$text .= '	public static function getIndexDataDB() : array' . PHP_EOL;
		$text .= '	{' . PHP_EOL;
		$text .= '		$db = DBConnector::connect();' . PHP_EOL;
		$text .= '//		$sql = ("SELECT `id`, * FROM ``");' . PHP_EOL;
		$text .= '//		$stmt = $db->query($sql);' . PHP_EOL;
		$text .= '//		$result = $stmt->fetchAll();' . PHP_EOL;
		$text .= '		return $result;' . PHP_EOL;
		$text .= '	}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }

  private static function editDB(){
		$text .= '	public static function getEditDataDB(int $id) : array' . PHP_EOL;
		$text .= '	{' . PHP_EOL;
		$text .= '		$db = DBConnector::connect();' . PHP_EOL;
		$text .= '//		$sql = ("SELECT `id`, * FROM `` WHERE `id` = :id");' . PHP_EOL;
		$text .= '//		$stmt = $db->prepare($sql);' . PHP_EOL;
    $text .= '//    $stmt->bindValue(\':id\', $id, \PDO::PARAM_INT);' . PHP_EOL;
    $text .= '//    $stmt->execute();' . PHP_EOL;
		$text .= '//		$result = $stmt->fetch();' . PHP_EOL;
		$text .= '		return $result;' . PHP_EOL;
		$text .= '	}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }

  private static function storeDB(){
		$text .= '	public static function storeDataDB(array $data) : void' . PHP_EOL;
		$text .= '	{' . PHP_EOL;
		$text .= '		$db = DBConnector::connect();' . PHP_EOL;
		$text .= '//		$sql = ("INSERT INTO `` (``)  VALUES ()");' . PHP_EOL;
		$text .= '//		$stmt = $db->prepare($sql);' . PHP_EOL;
    $text .= '//    $stmt->bindValue(\':\', $data, \PDO::PARAM_);' . PHP_EOL;
    $text .= '//    $stmt->execute();' . PHP_EOL;
		$text .= '	}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }

  private static function updateDB(){
		$text .= '	public static function updateDataDB(int $id, array $data) : void' . PHP_EOL;
		$text .= '	{' . PHP_EOL;
		$text .= '		$db = DBConnector::connect();' . PHP_EOL;
		$text .= '//		$sql = ("UPDATE `` SET `` = :  WHERE `id` = :id");' . PHP_EOL;
		$text .= '//		$stmt = $db->prepare($sql);' . PHP_EOL;
    $text .= '//    $stmt->bindValue(\':id\', $id, \PDO::PARAM_INT);' . PHP_EOL;
    $text .= '//    $stmt->execute();' . PHP_EOL;
		$text .= '	}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }

  private static function destroyDB(){
		$text .= '	public static function destroyDataDB(int $id) : void' . PHP_EOL;
		$text .= '	{' . PHP_EOL;
		$text .= '		$db = DBConnector::connect();' . PHP_EOL;
		$text .= '//		$sql = ("DELETE FROM ``, WHERE `id` = :id");' . PHP_EOL;
		$text .= '//		$stmt = $db->prepare($sql);' . PHP_EOL;
    $text .= '//    $stmt->bindValue(\':id\', $id, \PDO::PARAM_INT);' . PHP_EOL;
    $text .= '//    $stmt->execute();' . PHP_EOL;
		$text .= '	}' . PHP_EOL;
    $text .= PHP_EOL;
    return $text;
  }

	private static function viewTemplate($view, $viewAction){
      $fileName = lcfirst(self::$name) . $view . 'View.php';
			$fullName = ADMIN . PAGES . '/' . self::$name  . '/' . $view . '/' . $fileName;
			$text = '<?php $data = $this->getData(); ?>' . PHP_EOL;
			$text .= PHP_EOL;
			$text .= '<div class="'. lcfirst(self::$name) . '-' . lcfirst($view) . '">' . PHP_EOL;
			$text .= $viewAction;
			$text .= '</div>' . PHP_EOL;

			Filer::createFile($fullName, $text);
  }

  private static function indexView(){
    $text = PHP_EOL;
    self::viewTemplate("Index", $text);
  }

  private static function createView(){
    $text = ' <form class="' . lcfirst(self::$name) . 'create-form" action="/admin/' . lcfirst(self::$name) . '" method="post">' . PHP_EOL;
    $text .= '  <input class="' . lcfirst(self::$name) . 'create-input" type="text" name="">' . PHP_EOL;
    $text .= '  <a href="/admin/' . lcfirst(self::$name) . '">cancel</a>' . PHP_EOL;
    $text .= '  <input type="submit" value="apply">' . PHP_EOL;
    $text .= '</form>'. PHP_EOL;
    $text .= PHP_EOL;
    self::viewTemplate("Create", $text);
  }

  private static function editView(){
    $text = '  <form class="' . lcfirst(self::$name) . 'edit-form" action="/admin/' . lcfirst(self::$name) . '/<?php echo $data[\'' . self::$name . '\'][\'id\'];?>" method="post">' . PHP_EOL;
    $text .= '    <input class="' . lcfirst(self::$name) . 'edit-input" type="text" name="">' . PHP_EOL;
    $text .= '    <input type="hidden" name="_method" value="PATCH">' .PHP_EOL;
    $text .= '    <a href="/admin/' . lcfirst(self::$name) . '">cancel</a>' . PHP_EOL;
    $text .= '    <input type="submit" value="apply">' . PHP_EOL;
    $text .= '  </form>'. PHP_EOL;
    self::viewTemplate("Edit", $text);
  }

	private static function CSSTemplate($css, $cssAction){
    $fileName = lcfirst(self::$name) . $css . 'View.css';
		$fullName = ADMIN . PAGES . '/' . self::$name . '/' . $css . '/' . $fileName;
    $text = '/* .' . lcfirst(self::$name) . '-' . lcfirst($css) . '*/' . PHP_EOL;
    $text .= PHP_EOL;
		$text .= '/* .' . lcfirst(self::$name) . '-' . lcfirst($css) . '{' . PHP_EOL;
    $text .= '} ' . PHP_EOL;
		$text .= PHP_EOL;
    $text .= $cssAction;
		Filer::createFile($fullName, $text);
  }

  private static function indexCSS(){
    $text = '*/' . PHP_EOL;
    $text .= PHP_EOL;

    self::CSSTemplate("Index", $text);
  }

  private static function createCSS(){
		$text = '.' . lcfirst(self::$name) . '-create-form {' . PHP_EOL;
    $text .= '}' . PHP_EOL;
		$text .= '.' . lcfirst(self::$name) . '-create-input {' . PHP_EOL;
    $text .= '} */' . PHP_EOL;
    $text .= PHP_EOL;

    self::CSSTemplate("Create", $text);
  }

  private static function editCSS(){
		$text = '.' . lcfirst(self::$name) . '-edit-form {' . PHP_EOL;
    $text .= '}' . PHP_EOL;
		$text .= '.' . lcfirst(self::$name) . '-edit-input {' . PHP_EOL;
    $text .= '} */' . PHP_EOL;
    $text .= PHP_EOL;

    self::CSSTemplate("Edit", $text);
  }

	private static function importCSS(){
		$importFile = CSS_ADMIN . '/' . 'import.css';
		$text = PHP_EOL;
		$text .= '		/* ' . self::$name . ' styles */' . PHP_EOL; 
		$text .= '@import url("../../../App/Web/Admin/Views/Pages/' . self::$name . '/Index/' . self::$name . 'IndexView.css");' . PHP_EOL; 
		$text .= '@import url("../../../App/Web/Admin/Views/Pages/' . self::$name . '/Create/' . self::$name . 'CreateView.css");' . PHP_EOL; 
		$text .= '@import url("../../../App/Web/Admin/Views/Pages/' . self::$name . '/Edit/' . self::$name . 'EditView.css");' . PHP_EOL; 

		Filer::fileAppend($importFile, $text);

	}

	private static function JSTemplate($js, $JSAction){
		$fileName = lcfirst(self::$name) . $js . 'View.js';
		$fullName = ADMIN . PAGES . '/' . self::$name . '/' . $js . '/' . $fileName;
    $text = '//' . self::$name . ' ' . lcfirst($js) . PHP_EOL;
		$text .= PHP_EOL;
    $text .= '// class ' . self::$name . $js . '{'. PHP_EOL;
    $text .= PHP_EOL;
    $text .= "//   constructor() {" . PHP_EOL;
    $text .= "//   }" . PHP_EOL;
    $text .= PHP_EOL;
    $text .= $JSAction;

		Filer::createFile($fullName, $text);
		
	}
  
  private static function indexJS(){
    $text = '//if(document.location.pathname === "/admin/' . self::$name . '")' . PHP_EOL;
    $text .= '//new ' . self::$name . 'Index;' . PHP_EOL;
    self::JSTemplate('Index', $text);
  }

  private static function editJS(){
    $text = '//if(new RegExp(\'/admin/' . lcfirst(self::$name) .'/edit/\\\d+\').test(document.location.pathname))' . PHP_EOL;
    $text .= '//new '. self::$name . 'Edit;' . PHP_EOL;
    self::JSTemplate('Edit', $text);
  }
  
  private static function createJS(){
    $text = '//if(document.location.pathname === "/admin/' . self::$name . '/create" )' . PHP_EOL;
    $text .= '//new ' . self::$name . 'Create;' . PHP_EOL;
    self::JSTemplate('Create', $text);
  }

	private static function createRoute(){
		$fullName = ROUTES . '/' . 'admin.php';
		$text = '' . PHP_EOL;
    $text .= '# ' . self::$name .' #####################' . PHP_EOL;
    $text .= 'Resources::createRoutes(\'' . lcfirst(self::$name) . '\');';

		Filer::fileAppend($fullName, $text);
	}
}
