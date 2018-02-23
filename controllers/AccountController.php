<?php

namespace controllers;

use models\User;

class AccountController {

	public function actionIndex() {

		$userId = User::checkLogged();
		$user = User::getUserById($userId);

		if ($user['confirmation'] == "") {
			$this->actionSendConfirmationEmail();
		}

		$confirmed = ($user['confirmation'] == "confirmed");

		$pageTitle = $userName = User::getUserName($userId);
		require_once(ROOT . "/views/account/index.php");
		return true;
	}

	public function actionEdit() {

		$userId = User::checkLogged();
		$user = User::getUserById($userId);
		$name = $user['name'];
		$password = $user['password'];
		$result = false;

		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$password = $_POST['password'];

			$errors = false;

			if (!User::checkName($name)) {
				$errors[] = 'Имя не должно быть короче 2-х символов';
			}

			if (!User::checkPassword($password)) {
				$errors[] = 'Пароль не должен быть короче 6-ти символов';
			}

			if (!$errors) {
				$result = User::edit($userId, $name, $password);
			}

		}

		require_once(ROOT . '/views/account/edit.php');

		return true;
	}

	public function actionSendConfirmationEmail() {

		$userId = User::checkLogged();
		$confirmation = User::generateConfirmationCode($userId);
		$subject = "Confirm your account on JustRegMe";
		$bodyPath = ROOT . '/template/email/confirmation.php';
		$body = include($bodyPath);
		
		echo User::sendEmail($userId, $subject, $body);

	}

	public function actionAccept($confirmation) {

		User::confirmEmail($confirmation);
		header("Location: /account");
	}

}