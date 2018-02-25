<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 17.02.2018
 * Time: 19:42
 */

namespace controllers;

use models\User;
use components\Validator;

class UserController {

	/*
	 * Manages registration page
	 */
	public function actionRegister(): bool {

		$first_name = "";
		$last_name = "";
		$email = "";
		$password = "";
		$password_confirmation = "";
		$result = false;

		if (isset($_POST['submit'])) {
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$password_confirmation = $_POST['password_confirmation'];

			$errors = array();

			if (Validator::checkName($first_name)) $errors['first_name'] =Validator::checkName($first_name);
			if (Validator::checkName($last_name)) $errors['last_name'] = Validator::checkName($last_name);
			if (Validator::checkEmail($email)) $errors['email'] = Validator::checkEmail($email);
			if (Validator::checkPassword($password)) $errors['password'] = Validator::checkPassword($password);
			if (Validator::checkPasswordConfirmation($password, $password_confirmation)) $errors['password_confirmation'] =
				Validator::checkPasswordConfirmation($password, $password_confirmation);


			if (empty($errors)) {
				$result = User::register($first_name, $last_name, $email, $password);
				if ($result > 0) {
					User::auth($result);
					header("Location: /account");
				}
			}

		}
		$pageTitle = 'Registration Form';
		require_once(ROOT . '/views/user/register.php');

		return true;
	}

	/*
	 * Manages login procedure
	 */
	public static function actionLogin():bool {

		$email = "";
		$password = "";

		if (isset($_POST['submit'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];

			$errors = array();

			$userId = User::checkUserData($email, $password);

			if (!$userId) {
				$errors['login'] = "Wrong credentials";
			} else {
				User::auth($userId);
				header("Location: /account");
			}
		}
		$pageTitle = 'Login';
		require_once(ROOT . '/views/user/login.php');
		return true;
	}

	/*
	 * Manages logout procedure
	 */
	public static function actionLogout() {

		User::logout();
	}

}