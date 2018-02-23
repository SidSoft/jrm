<?php

namespace models;

use components\Db;

class User {

	public static function edit($id, $name, $password) {
		$db = Db::getConnection();

		$sql = "UPDATE `user` SET (`name` = :name, `password` = :password) WHERE `id` = :id";
		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, \PDO::PARAM_STR);
		$result->bindParam(':password', $password, \PDO::PARAM_STR);
		$result->bindParam(':id', $id, \PDO::PARAM_STR);

		return $result->execute();
	}

	public static function register(string $first_name, string $last_name, string $email, string $password, int $role = 0): int {
		$db = Db::getConnection();

		$sql = "INSERT INTO `user` (`first_name`, `last_name`, `email`, `password`, `role`, `confirmation`) 
				VALUES (:first_name, :last_name, :email, :password, :role, :confirmation)";

		$confirmation = "";
		$password = md5($password);
		$statement = $db->prepare($sql);
		$statement->bindParam(':first_name', $first_name, \PDO::PARAM_STR);
		$statement->bindParam(':last_name', $last_name, \PDO::PARAM_STR);
		$statement->bindParam(':email', $email, \PDO::PARAM_STR);
		$statement->bindParam(':password', $password, \PDO::PARAM_STR);
		$statement->bindParam(':role', $role, \PDO::PARAM_STR);
		$statement->bindParam(':confirmation', $confirmation, \PDO::PARAM_STR);

		if ($statement->execute()) {
			$last_id = intval($db->lastInsertId());
		} else {
			$last_id = 0;
		}
		return $last_id;
	}

	public static function checkName(string $name): string {

		 if (!$name) $error = "This field is required";
		 elseif (strlen($name) < 2) $error = "This field must be minimum 2 characters long";
		 else $error = "";
		 return $error;
	}

	public static function checkEmail(string $email): string {

		if (!$email) $error = "This field is required";
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = "Email must be valid";
		elseif (self::checkEmailExists($email)) $error = "This email already registered";
		else $error = "";
		return $error;
	}

	public static function checkPassword(string $password): string {

		if (!$password) $error = "This field is required";
		elseif (strlen($password) < 6) $error = "This field must be minimum 6 characters long";
		else $error = "";
		return $error;
	}

	public static function checkPasswordConfirmation(string $password, string $password_confirmation) {

		if ($password != $password_confirmation) $error = "Password does not match the confirm password";
		else $error = "";
		return $error;
	}

	public static function checkEmailExists(string $email): bool {

		$db = Db::getConnection();

		$sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
		$statement = $db->prepare($sql);
		$statement->bindParam('email',$email, \PDO::PARAM_STR);
		$statement->execute();
		if ($statement->fetchColumn()) return true;
		return false;
	}

	public static function checkUserData(string $email, string $password) {

		$db = Db::getConnection();

		$sql = "SELECT * FROM `user` WHERE email = :email AND password = :password";

		$statement = $db->prepare($sql);
		$password = md5($password);
		$statement->bindParam(':email', $email, \PDO::PARAM_STR);
		$statement->bindParam(':password', $password, \PDO::PARAM_STR);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->execute();

		$user = $statement->fetch();
		if ($user) {
			return $user['id'];
		}
		return false;
	}

	public static function auth(int $userId) {

		$_SESSION['user'] = $userId;
	}

	public static function logout() {

		unset($_SESSION['user']);

		header("Location: /");
	}

	public static function isGuest() {

		if (isset($_SESSION['user'])) {
			return false;
		}
		return true;
	}

	public static function checkLogged(): int {

		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}

		header("Location: /user/login");
	}

	public static function getUserById($id) {

		if ($id) {
			$db = Db::getConnection();
			$sql = "SELECT * FROM `user` WHERE `id` = :id";

			$statement = $db->prepare($sql);
			$statement->bindParam(':id', $id, \PDO::PARAM_STR);

			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$statement->execute();

			return $statement->fetch();
		}

	}

	public static function getUserName(int $id): string {

		$user = self::getUserById($id);
		return "{$user['first_name']} {$user['last_name']}";

	}

	public static function sendEmail(int $userId, string $subject, string $body, string $type = "html"): bool {

		$user = self::getUserById($userId);
		$to = $user['email'];
		$headers = "";
		if ($type == "html") {
			$headers = "MIME-Version: 1.0" . "\r\n" .
			           "Content-type: text/html; charset=UTF-8" . "\r\n";
		}
		return mail($to, $subject, $body, $headers);
	}

	public static function generateConfirmationCode(int $userId): string {

		$confirmation = bin2hex(random_bytes(16));

		$db = Db::getConnection();

		$sql = "UPDATE `user` SET `confirmation` = :confirmation WHERE `id` = :id";

		$statement = $db->prepare($sql);
		$statement->bindParam(':confirmation', $confirmation, \PDO::PARAM_STR);
		$statement->bindParam(':id', $userId, \PDO::PARAM_STR);

		$statement->execute();

		return $confirmation;
	}

	public static function confirmEmail(string $confirmation) {

		$db = Db::getConnection();

		$sql = "SELECT * FROM `user` WHERE `confirmation` = :confirmation";

		$statement = $db->prepare($sql);
		$statement->bindParam(':confirmation', $confirmation, \PDO::PARAM_STR);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->execute();

		$user = $statement->fetch();
		if ($user) {
			$sql = "UPDATE `user` SET `confirmation` = 'confirmed' WHERE `id` = :id";

			$statement = $db->prepare($sql);
			$statement->bindParam(':id', $user['id'], \PDO::PARAM_STR);

			$statement->execute();

			self::auth($user['id']);
		}

	}
}