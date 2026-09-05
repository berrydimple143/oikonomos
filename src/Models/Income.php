<?php
	namespace App\Models;

	use App\Core\Database;
	use PDO;

	class Income {	

		public static function getIncomePerMonth($before, $after, $uid) {
			$pdo = Database::connect();			
			$income = $pdo->query("SELECT SUM(amount) as total_amount FROM incomes WHERE date_received >= '$before' AND date_received <= '$after' AND user_id = $uid");
			return $income->fetch();
		}

		public static function getIncomes($uid) {
			$pdo = Database::connect();
			$incomes = $pdo->query("SELECT id, user_id, source, description, amount, status, received_from, date_received, DATE_FORMAT(date_received, '%M %d, %Y') AS received_on, created_at FROM incomes WHERE user_id=$uid ORDER BY created_at DESC");
			return $incomes->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getIncome($id) {
			$pdo = Database::connect();
			$income = $pdo->query("SELECT * FROM incomes WHERE id=$id");
			return $income->fetch(PDO::FETCH_OBJ);
		}
        
		public static function changeStatus($id, $status) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$experience = $pdo->prepare("UPDATE experiences SET status=?, updated_at=? WHERE id=?");
			return $experience->execute([$status, $updated_at, $id]);
		}

		public static function create($user_id, $source, $amount, $received_from, $date_received, $description) {
			$pdo = Database::connect();
			$experience = $pdo->prepare("INSERT INTO incomes(user_id, source, amount, received_from, date_received, description) VALUES(:user_id, :source, :amount, :received_from, :date_received, :description)");
			$inserted = $experience->execute([
				":user_id" => $user_id,
				":source" => $source,
				":amount" => $amount,
				":received_from" => $received_from,
				":date_received" => $date_received,
				":description" => $description
			]);

			if($inserted) {				
				return self::getIncomes($user_id);
			} else {
				return false;
			}
		}

		public static function update($user_id, $source, $amount, $received_from, $date_received, $description, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$income = $pdo->prepare("UPDATE incomes SET source=?, amount=?, received_from=?, date_received=?, description=?, updated_at=? WHERE id=?");
			 $updated = $income->execute([$source, $amount, $received_from, $date_received, $description, $updated_at, $id]);				
			 if($updated) {
				return self::getIncomes($user_id);
			 } else {
				return false;
			 }
		}

		public static function delete($id, $uid) {
			$pdo = Database::connect();
			$income = $pdo->prepare("DELETE FROM incomes WHERE id=?");
			$deleted = $income->execute([$id]);	
			if($deleted) {
				return self::getIncomes($uid);
			} else {
				return false;
			}
		}
	}
?>