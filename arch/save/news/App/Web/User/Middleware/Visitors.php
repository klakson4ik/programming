<?php

namespace App\Web\User\Middleware;
use vendor\core\libs\DB\DBConnector;
use vendor\core\libs\Cache;

class Visitors {
  public static function init(){
    if(!isset($_REQUEST['PHPSESSID'])){
      $db = DBConnector::connect();
      $IP = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "0.0.0.0";
      $ips = [];
      //die(debug($_SERVER['REMOTE_ADDR']));
      if(Cache::getCache('visitors_date') == date('Y-m-d')){
        $is_ip = false;
        $ips = Cache::getCache('visitors_ip');
       // die(debug($ips));
        for($i=0; $i<count($ips); $i++){
          if($ips[$i] == $IP){
            $is_ip = true;
            break;
          }
        }
        if(!$is_ip){
          array_push($ips, $IP);
          Cache::setCache('visitors_ip', $ips, 3600*24);
          $sql = ("UPDATE `traffic` SET `count` = `count` + 1 WHERE `date` = :date ");
          $stmt = $db->prepare($sql);
          $stmt->bindValue(':date', date('Y-m-d'), \PDO::PARAM_STR);
          $stmt->execute();
          $sql = ("INSERT INTO `visitors` (`ip_address` , `page_id`, `date`) VALUES  (:ip, :page, NOW())");
          $stmt = $db->prepare($sql);
          $id = isset($_GET['id']) ? $_GET['id'] : '0';
          $stmt->bindValue(':ip', $IP, \PDO::PARAM_STR);
          $stmt->bindValue(':page', $id, \PDO::PARAM_INT);
          $stmt->execute();
        }
      }else{
        Cache::setCache('visitors_date', date('Y-m-d'), 3600*24);
        array_push($ips, "0.0.0.0");
        array_push($ips, $IP);
        Cache::setCache('visitors_ip', $ips, 3600*24);
        $sql = ("INSERT INTO `traffic` (`count`, `date`) VALUE (1 , :date )");
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':date', date('Y-m-d'), \PDO::PARAM_STR);
        $stmt->execute();
        $sql = ("INSERT INTO `visitors` (`ip_address`, `page_id`, `date`) VALUES (:ip, :page, NOW())");
        $stmt = $db->prepare($sql);
        $id = isset($_GET['id']) ? $_GET['id'] : '0';
        $stmt->bindValue(':ip', $IP, \PDO::PARAM_STR);
        $stmt->bindValue(':page', $id, \PDO::PARAM_INT);
        $stmt->execute();
      }
    }
  } 
}
