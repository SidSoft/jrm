<?php

namespace controllers;

use models\User;

class AccountController {

	/*
	 * Manages main page of User's personal aria
	 */
	public function actionIndex(): bool {

		$userId = User::checkLogged();
		$user = User::getUserById($userId);

		if ($user['confirmation'] == "") {
			$this->actionSendConfirmationEmail();
		}

		$confirmed = ($user['confirmation'] == "confirmed"); // sets confirmed email flag

		$pageTitle = $userName = User::getUserName($userId);
		require_once(ROOT . "/views/account/index.php");
		return true;
	}

	/*
	 * Manages User's data edit page
	 */
	public function actionEdit(): bool {

		$userId = User::checkLogged();
		$user = User::getUserById($userId);
		$first_name = $user['first_name'];
		$last_name = $user['last_name'];
		$result = false;

		if (isset($_POST['submit'])) {
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];

			$errors = array();

			if (User::checkName($first_name)) $errors['first_name'] = User::checkName($first_name);
			if (User::checkName($last_name)) $errors['last_name'] = User::checkName($last_name);

			if (empty($errors)) {
				$result = User::edit($userId, $first_name, $last_name);
			}
		}
		$pageTitle = "Edit Details";
		require_once(ROOT . '/views/account/edit.php');

		return true;
	}

	/*
	 * Manages Password change page
	 */
	public function actionPasswordChange() {

		$userId = User::checkLogged();
		$user = User::getUserById($userId);
		$old_password = "";
		$password = "";
		$password_confirmation = "";
		$result = false;

		if (isset($_POST['submit'])) {
			$old_password = $_POST['old_password'];
			$password = $_POST['password'];
			$password_confirmation = $_POST['password_confirmation'];

			$errors = array();

			if (User::passwordCheck($userId, $old_password)) {
				if (User::checkPassword($password)) $errors['password'] = User::checkPassword($password);
				if (User::checkPasswordConfirmation($password, $password_confirmation)) $errors['password_confirmation'] =
					User::checkPasswordConfirmation($password, $password_confirmation);
			} else $errors['old_password'] = "Wrong old password";

			if (empty($errors)) {
				$result = User::passwordChange($userId, $password);
			}
		}
		$pageTitle = "Password Change";
		require_once(ROOT . '/views/account/password_change.php');

		return true;
	}

	/*
	 * Sends Confirmation email
	 */
	public function actionSendConfirmationEmail() {

		$userId = User::checkLogged();
		$confirmation = User::generateConfirmationCode($userId);
		$subject = "Confirm your account on JustRegMe";
		$bodyPath = ROOT . '/template/email/confirmation.php';
		$body = include($bodyPath); //loads HTML-body from template
		
		echo User::sendEmail($userId, $subject, $body);

	}

	/*
	 * Manages email confirmation procedure
	 */
	public function actionAccept(string $confirmation) {

		User::confirmEmail($confirmation);
	}

}