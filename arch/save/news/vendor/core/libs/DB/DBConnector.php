<?php

namespace vendor\core\libs\DB;

class DBConnector
{

    public static function connect() : \PDO
    {
			require_once CONFIG . '/configDB.php';
			try {
				return new \PDO(DB_DSN, DB_LOGIN, DB_PASSWORD, DB_OPT);
			}
			catch(PDOException $e) {
				$e->getMessage();
			}
    }

}


