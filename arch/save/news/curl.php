<?php
	require_once './vendor/core/libs/AutoComplete/Curl.php';
	use vendor\core\libs\AutoComplete\Curl;
  $curl = new Curl;
  print_r($curl->getData());
?>
