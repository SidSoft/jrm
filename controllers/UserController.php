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
	public function actionRegister() {

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

			if ($error = Validator::checkName($first_name)) $errors['first_name'] = $error;
			if ($error = Validator::checkName($last_name)) $errors['last_name'] = $error;
			if ($error = Validator::checkEmail($email)) $errors['email'] = $error;
			if ($error = Validator::checkPassword($password)) $errors['password'] = $error;
			if ($error = Validator::checkPasswordConfirmation($password, $password_confirmation))
				$errors['password_confirmation'] = $error;


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
	public static function actionLogin() {

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