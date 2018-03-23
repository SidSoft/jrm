<?php

namespace components;

class Db {

	/*
	 * DB initializations
	 */
	public static function getConnection(){
		$paramsPath = ROOT . '/config/db_params.php';
		$dbParams = include($paramsPath);

		$db = new \PDO("sqlite:{$dbParams['db_name']}");
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $db;
	}

}