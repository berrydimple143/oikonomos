<?php
	namespace App\Models;

	use App\Core\Database;
	use PDO;
	use App\Functions\Utilities;

	class Expense {	

		public static function getExpenseWithDates($before, $after, $uid) {
			$pdo = Database::connect();			
			$expense = $pdo->query("SELECT SUM(amount) as total_amount, GROUP_CONCAT(date_expensed SEPARATOR ',') AS date_expensed, GROUP_CONCAT(amount SEPARATOR ',') AS amounts, GROUP_CONCAT(asset SEPARATOR ',') AS assets, GROUP_CONCAT(received_by SEPARATOR ',') AS recipients, user_id FROM expenses WHERE date_expensed >= '$before' AND date_expensed <= '$after' AND user_id = $uid GROUP BY user_id");
			return $expense->fetch();
		}

		public static function getExpenses($uid, $year, $month, $expenseSource) {
			if(empty($month)) {
				$from = $year."-01-01 00:00:00";
				$to = $year."-12-31 23:59:59";
			} else {
				$m = Utilities::getNumberMonth($month);	
				$day = Utilities::getLastDaysOfYearMonth($year, $m[1]);							
				$from = $year."-".$m[0]."-01 00:00:00";
				$to = $year."-".$m[0]."-".$day." 23:59:59";
			}		
			$src = "";
			if(!empty($expenseSource)) {
				$src = " AND asset='$expenseSource'";
			}	
			$pdo = Database::connect();
			$expenses = $pdo->query("SELECT id, user_id, asset, description, amount, status, received_by, receipt_number, date_expensed, DATE_FORMAT(date_expensed, '%M %d, %Y') AS expensed_on, created_at FROM expenses WHERE user_id=$uid AND date_expensed >= '$from' AND date_expensed <= '$to' $src ORDER BY created_at DESC");
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

		public static function create($user_id, $asset, $amount, $received_by, $date_expensed, $description, $receipt_number, $year, $month, $expenseSource) {
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
				return self::getExpenses($user_id, $year, $month, $expenseSource);
			} else {
				return false;
			}
		}

		public static function update($user_id, $asset, $amount, $received_by, $date_expensed, $description, $receipt_number, $year, $month, $expenseSource, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$expense = $pdo->prepare("UPDATE expenses SET asset=?, amount=?, received_by=?, date_expensed=?, description=?, receipt_number=?, updated_at=? WHERE id=?");
			 $updated = $expense->execute([$asset, $amount, $received_by, $date_expensed, $description, $receipt_number, $updated_at, $id]);				
			 if($updated) {
				return self::getExpenses($user_id, $year, $month, $expenseSource);
			 } else {
				return false;
			 }
		}

		public static function delete($id, $uid, $year, $month, $expenseSource) {
			$pdo = Database::connect();
			$expense = $pdo->prepare("DELETE FROM expenses WHERE id=?");
			$deleted = $expense->execute([$id]);	
			if($deleted) {
				return self::getExpenses($uid, $year, $month, $expenseSource);
			} else {
				return false;
			}
		}
	}
?>