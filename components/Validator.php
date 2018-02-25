<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 25.02.2018
 * Time: 13:17
 */

namespace components;


class Validator {

	/*
	 * Name field validation
	 * Returns current error if any
	 */
	public static function checkName(string $name): string {

		if (!$name) $error = "This field is required";
		elseif (strlen($name) < 2) $error = "This field must be minimum 2 characters long";
		else $error = "";
		return $error;
	}

	/*
	 * Email field validation
	 * Check email uniqueness
	 * Returns current error if any
	 */
	public static function checkEmail(string $email): string {

		if (!$email) $error = "This field is required";
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = "Email must be valid";
		elseif (self::checkEmailExists($email)) $error = "This email already registered";
		else $error = "";
		return $error;
	}

	/*
	 * Check if entered email already used for registration
	 * Returns TRUE if entered email already exists
	 */
	public static function checkEmailExists(string $email): bool {

		$db = Db::getConnection();

		$sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
		$statement = $db->prepare($sql);
		$statement->bindParam(':email',$email, \PDO::PARAM_STR);
		$statement->execute();
		if ($statement->fetchColumn()) return true;
		return false;
	}


	/*
	 * Password field validation
	 * Returns current error if any
	 */
	public static function checkPassword(string $password): string {

		if (!$password) $error = "This field is required";
		elseif (strlen($password) < 6) $error = "This field must be minimum 6 characters long";
		else $error = "";
		return $error;
	}

	/*
	 * Check if confirmation password matches main password
	 * Returns current error if any
	 */
	public static function checkPasswordConfirmation(string $password, string $password_confirmation): string {

		if ($password != $password_confirmation) $error = "Password does't match the confirmation password";
		else $error = "";
		return $error;
	}
}