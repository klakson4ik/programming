<?php

namespace vendor\core\libs\DB;

class DBCreateTable
{
  public static function createTable()
  {
    $db = DBConnector::connect();
    $sql = ("CREATE TABLE `:table_name` (`id` int unsigned AUTO_INCREMENT PRIMARY KEY) ENGINE='InnoDB' COLLATE 'utf8_general_ci'"); 
    $sql = ("ALTER TABLE :table_name ADD :value :type(:size) COLLATE :collate :is_null DEFAULT :default COMMENT :comment");
    $sql = ("ALTER TABLE :table_name ADD :value :type(:size) :options :is_null DEFAULT :default COMMENT :comment");
    //  ADD `2` int(11) unsigned NULL DEFAULT '0' COMMENT '33333'
    //  ADD `ddd` char(100) COLLATE 'armscii8_general_ci' NULL DEFAULT 'ee' COMMENT '55555'
    //  ADD `eeee` int(11) unsigned zerofill NULL COMMENT '5555' AUTO_INCREMENT UNIQUE AFTER `parent_id`

    $intArray = ['table_name', 'value', 'type', 'size', 'options', 'is_null', 'default', 'comment'];
    $charArray = ['table_name', 'value', 'type', 'size', 'collate', 'is_null', 'default', 'comment'];
    $str = '"ALTER TABLE :table_name ADD :value :type(:size) ';
    foreach($iarray as $key=>$value){
      if(array_key_exists($key, $carray,))
        $str .= $key . ' ';
    }
    $str .= '"';
  }
}

