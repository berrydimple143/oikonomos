<?php
	namespace App\Models;

	use App\Core\Database;
	use PDO;
	use DateTimeImmutable;
	use DateInterval;

	class User {

		public static function updatePlan($code) {
			$pdo = Database::connect();
			$dt = date('Y-m-d H:i:s');
			$date = new DateTimeImmutable($dt);
    		$new_date = $date->add(new DateInterval('P1W'));
    		$expiry_date = $new_date->format('Y-m-d H:i:s'); 
			$user = $pdo->prepare("UPDATE users SET starting_date=?, expiry_date=?, updated_at=? WHERE code=?");
			$updated = $user->execute([$dt, $expiry_date, $dt, $code]);	
			if($updated) {
				return true;
			 } else {
				return false;
			 }
		}

		public static function updateCurrency($currency, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$user = $pdo->prepare("UPDATE users SET currency=?, updated_at=? WHERE id=?");
			$updated = $user->execute([$currency, $updated_at, $id]);	
			if($updated) {
				return self::getUser($id);
			 } else {
				return false;
			 }
		}

		public static function changePassword($password, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$user = $pdo->prepare("UPDATE users SET password=?, updated_at=? WHERE id=?");
			$updated = $user->execute([password_hash($password, PASSWORD_DEFAULT), $updated_at, $id]);	
			if($updated) {
				return true;
			 } else {
				return false;
			 }
		}

		public static function changeStatus($id, $status) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$user = $pdo->prepare("UPDATE users SET status=?, updated_at=? WHERE id=?");
			$usr = $user->execute([$status, $updated_at, $id]);
			$classification = 'nonpaying';
			if($status == 1) {
				$classification = 'paying';
			}
			$type = $pdo->prepare("UPDATE user_types SET classification=? WHERE user_id=?");			
			return $type->execute([$classification, $id]);
		}

		public static function findCode($code) {
			$pdo = Database::connect();			
			$user = $pdo->query("SELECT COUNT(*) FROM users WHERE code = '$code'");
			return $user->fetchColumn();
		}

		public static function countUser($email) {
			$pdo = Database::connect();			
			$user = $pdo->query("SELECT COUNT(*) FROM users WHERE email = '$email'");
			return $user->fetchColumn();
		}
		
		public static function getUsers() {
			$pdo = Database::connect();
			$user = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
			return $user->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function findUserByEmail($email) {
			$pdo = Database::connect();
			$user = $pdo->query("SELECT * FROM users WHERE email='$email'");
			return $user->fetch(PDO::FETCH_OBJ);
		}

		public static function getAllUserWithSearch($search) {
			$pdo = Database::connect();			
			$user = $pdo->query("SELECT usr.id AS id, usr.firstname AS firstname, usr.lastname AS lastname, usr.middlename AS middlename, usr.status AS status, utype.classification AS classification FROM users AS usr INNER JOIN user_types AS utype ON usr.id = utype.user_id WHERE usr.firstname LIKE '%$search%' OR usr.lastname LIKE '%$search%' OR usr.middlename LIKE '%$search%' OR utype.classification LIKE '%$search%' ORDER BY usr.created_at DESC");			
			return $user->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getUser($id) {
			$pdo = Database::connect();
			$user = $pdo->query("SELECT * FROM users WHERE id=$id");
			return $user->fetch(PDO::FETCH_ASSOC);
		}

		public static function createUser($firstname, $lastname, $email, $password, $organization, $code) {
			$pdo = Database::connect();
			$user = $pdo->prepare("INSERT INTO users(firstname, lastname, email, password, organization, code, role, status, created_at, updated_at) VALUES(:firstname, :lastname, :email, :password, :organization, :code, :role, :status, :created_at, :updated_at)");
			$dt = date('Y-m-d H:i:s');
			return $user->execute([
				":firstname" =>$firstname,
				":lastname" => $lastname,
				":email" => $email,
				":password" => password_hash($password, PASSWORD_DEFAULT),
				":organization" => $organization,
				":code" => $code,
				":role" => 'member',
				":status" => 0,
				":created_at" => $dt,
				":updated_at" => $dt
			]);
		}

		public static function updateUser($firstname, $middlename, $lastname, $email, $username, $phone, $mobile, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$user = $pdo->prepare("UPDATE users SET firstname=?, middlename=?, lastname=?, email=?, username=?, phone=?, mobile=?, updated_at=? WHERE id=?");
			return $user->execute([$firstname, $middlename, $lastname, $email, $username, $phone, $mobile, $updated_at, $id]);	
		}

		public static function deleteUser($id) {
			$pdo = Database::connect();
			$user = $pdo->prepare("DELETE FROM users WHERE id=?");
			return $user->execute([$id]);			
		}
	}
?>