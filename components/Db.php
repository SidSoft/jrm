<?php

namespace components;

class Db {

	public static function getConnection(): object {
		$paramsPath = ROOT . '/config/db_params.php';
		$params = include($paramsPath);

		$db = new \PDO("sqlite:{$params['db_name']}");
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $db;
	}

}