<?php
	namespace App\Models;

	use App\Core\Database;
	use PDO;

	class Expense {	

		public static function getExpensePerMonth($before, $after, $uid) {
			$pdo = Database::connect();			
			$expense = $pdo->query("SELECT SUM(amount) as total_amount FROM expenses WHERE date_expensed >= '$before' AND date_expensed <= '$after' AND user_id = $uid");
			return $expense->fetch();
		}

		public static function getExpenses($uid) {
			$pdo = Database::connect();
			$expenses = $pdo->query("SELECT id, user_id, asset, description, amount, status, received_by, receipt_number, date_expensed, DATE_FORMAT(date_expensed, '%M %d, %Y') AS expensed_on, created_at FROM expenses WHERE user_id=$uid ORDER BY created_at DESC");
			return $expenses->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getExpense($id) {
			$pdo = Database::connect();
			$expense = $pdo->query("SELECT * FROM expenses WHERE id=$id");
			return $expense->fetch(PDO::FETCH_OBJ);
		}
        
		public static function changeStatus($id, $status) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$experience = $pdo->prepare("UPDATE experiences SET status=?, updated_at=? WHERE id=?");
			return $experience->execute([$status, $updated_at, $id]);
		}

		public static function create($user_id, $asset, $amount, $received_by, $date_expensed, $description, $receipt_number) {
			$pdo = Database::connect();
			$experience = $pdo->prepare("INSERT INTO expenses(user_id, asset, amount, received_by, date_expensed, description, receipt_number) VALUES(:user_id, :asset, :amount, :received_by, :date_expensed, :description, :receipt_number)");
			$inserted = $experience->execute([
				":user_id" => $user_id,
				":asset" => $asset,
				":amount" => $amount,
				":received_by" => $received_by,
				":date_expensed" => $date_expensed,
				":description" => $description,
                ":receipt_number" => $receipt_number
			]);

			if($inserted) {				
				return self::getExpenses($user_id);
			} else {
				return false;
			}
		}

		public static function update($user_id, $asset, $amount, $received_by, $date_expensed, $description, $receipt_number, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$expense = $pdo->prepare("UPDATE expenses SET asset=?, amount=?, received_by=?, date_expensed=?, description=?, receipt_number=?, updated_at=? WHERE id=?");
			 $updated = $expense->execute([$asset, $amount, $received_by, $date_expensed, $description, $receipt_number, $updated_at, $id]);				
			 if($updated) {
				return self::getExpenses($user_id);
			 } else {
				return false;
			 }
		}

		public static function delete($id, $uid) {
			$pdo = Database::connect();
			$expense = $pdo->prepare("DELETE FROM expenses WHERE id=?");
			$deleted = $expense->execute([$id]);	
			if($deleted) {
				return self::getExpenses($uid);
			} else {
				return false;
			}
		}
	}
?>