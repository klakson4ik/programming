<?php
namespace App\Services;

class EnvEnvironmentStorage implements \Techart\Frontend\EnvironmentStorageInterface {

	public function getFromConfig($name) {
		return env('FRONTEND_ENV', 'prod');
	}

	public function getFromRequest($name) {
		return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
	}

	public function getFromSession($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	public function setToSession($name, $value) {
		$_SESSION[$name] = $value;
	}
}
