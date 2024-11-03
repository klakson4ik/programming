<?php


namespace vendor\core\libs\Validator;


class Validator
{
    private $rules = [];
    protected $errors = [];
    private $success = false;
    private $attributs = [];

    public function __construct($rules, $attributes)
    {
        $this->rules = $rules;
        $this->attributs = $attributes;
        $this->checkRules();

    }

    public function getResultValidate()
    {
        return ['success' =>$this->success, 'validateErrors' => $this->errors];
    }

    private function checkRules()
    {
        $count = 0;
        foreach ($this->rules as $rule=>$param)
        {
            $objRules = new Rules();
            if(method_exists($objRules, $rule))
            {
                $result = $objRules->$rule($param, $this->attributs);

                if(!$result)
                    ++$count;
                else
                    $this->errors[] = $result;
            }
            else {
                throw new \Exception("{$rule} такого правила не существует", 404);
            }
        }
        $this->success =  count($this->rules) == $count ? true : false ;
    }
}