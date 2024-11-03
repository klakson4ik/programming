<?php


namespace vendor\core\libs\Validator;


class Rules
{
    private $errors = [];
    private $success = 0;

    public  function required ($rule, $param)
    {

       foreach ($param as $key=>$value){
           if(in_array($key, $rule)){
               if(!empty($value) && !ctype_space($value))
                   ++$this->success;
               else{
                   $this->errors[] = "Поле " . $key . " должно быть заполнено";
               }
           }
       }

       return count($param) == $this->success ? false : $this->errors;
    }

    public function lengthMin($rule, $param)
    {

        foreach ($rule as $key=>$value)
        {
            if(array_key_exists($key, $param))
            {
                if (strlen($param[$key]) >= (int)$value)
                    ++$this->success;
                else
                    $this->errors[] = "В поле " . $key . " недостаточно символов";
            }
        }
        return count($rule) == $this->success ? false : $this->errors;
    }

    public function pattern($rule, $param)
    {

        foreach ($rule as $key=>$value)
        {

            if(array_key_exists($key, $param))
            {
                if (preg_match("#{$value}#i", $param[$key]))
                    ++$this->success;
                else
                    $this->errors[] = " поле " . $key . " не совподает с шаблоном";
            }
        }
        return count($rule) == $this->success ? false : $this->errors;
    }

}

