<?php

namespace models;

use components\Db;

class User {

	/*
	 * Edit user details
	 */
	public static function edit(int $userId, string $first_name, string $last_name): bool {

		$db = Db::getConnection();

		$sql = "UPDATE `user` SET `first_name` = :first_name, `last_name` = :last_name WHERE `id` = :id";

		$result = $db->prepare($sql);
		$result->bindParam(':first_name', $first_name, \PDO::PARAM_STR);
		$result->bindParam(':last_name', $last_name, \PDO::PARAM_STR);
		$result->bindParam(':id', $userId, \PDO::PARAM_STR);

		return $result->execute();
	}

	/*
	 * Change User password
	 */
	public static function passwordChange (int $userId, string $password): bool {

		$db = Db::getConnection();

		$sql = "UPDATE `user` SET `password` = :password WHERE `id` = :id";

		$password = password_hash($password, PASSWORD_DEFAULT);
		$result = $db->prepare($sql);
		$result->bindParam(':password', $password, \PDO::PARAM_STR);
		$result->bindParam(':id', $userId, \PDO::PARAM_STR);

		return $result->execute();
	}

	/*
	 * Check if password corresponds UserID
	 */
	public static function passwordCheck(int $userId, string $password): bool {

		$db = Db::getConnection();

		$sql = "SELECT * FROM `user` WHERE `id` = :id";

		$statement = $db->prepare($sql);
		$statement->bindParam(':id', $userId, \PDO::PARAM_STR);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->execute();

		$user = $statement->fetch();
		if ($user && password_verify($password, $user['password'])) return true;
		return false;
	}

	/*
	 * User registration
	 * Returns ID of registered user
	 */
	public static function register(string $first_name, string $last_name, string $email, string $password, int $role = 0): int {

		$db = Db::getConnection();

		$sql = "INSERT INTO `user` (`first_name`, `last_name`, `email`, `password`, `role`, `confirmation`) 
				VALUES (:first_name, :last_name, :email, :password, :role, :confirmation)";

		$confirmation = "";
		$password = password_hash($password, PASSWORD_DEFAULT);
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
	 * Check if user with entered email and password exists
	 * Returns UserID or FALSE
	 */
	public static function checkUserData(string $email, string $password) {

		$db = Db::getConnection();

		$sql = "SELECT * FROM `user` WHERE email = :email";

		$statement = $db->prepare($sql);
		$statement->bindParam(':email', $email, \PDO::PARAM_STR);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->execute();

		$user = $statement->fetch();
		if ($user && password_verify($password, $user['password'])) {
			return $user['id'];
		}
		return false;
	}

	/*
	 * Authentication
	 */
	public static function auth(int $userId) {

		$_SESSION['user'] = $userId;
	}

	/*
	 * Logout
	 */
	public static function logout() {

		unset($_SESSION['user']);

		header("Location: /");
	}

	/*
	 * Check if user is logged
	 * Returns UserID or redirect on login page
	 */
	public static function checkLogged(): int {

		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}

		header("Location: /user/login");
	}

	/*
	 * Returns User data
	 */
	public static function getUserById(int $userId): iterable {

		if ($userId) {
			$db = Db::getConnection();
			$sql = "SELECT * FROM `user` WHERE `id` = :id";

			$statement = $db->prepare($sql);
			$statement->bindParam(':id', $userId, \PDO::PARAM_STR);

			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$statement->execute();

			return $statement->fetch();
		}

	}

	/*
	 * Returns User name string
	 */
	public static function getUserName(int $id): string {

		$user = self::getUserById($id);
		return "{$user['first_name']} {$user['last_name']}";

	}

	/*
	 * Send email
	 */
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

	/*
	 * Generates new Confirmation code and stores it in DB
	 */
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

	/*
	 * Registered user's email confirmation.
	 */
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
		header("Location: /account");
	}
}