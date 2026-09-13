<?php
	namespace App\Models;

	use App\Core\Database;
	use PDO;
	use App\Functions\Utilities;

	class Income {	

		public static function getIncomeWithDates($before, $after, $uid) {
			$pdo = Database::connect();			
			$income = $pdo->query("SELECT SUM(amount) as total_amount, GROUP_CONCAT(date_received SEPARATOR ',') AS dates_received, GROUP_CONCAT(amount SEPARATOR ',') AS amounts, GROUP_CONCAT(source SEPARATOR ',') AS sources, GROUP_CONCAT(received_from SEPARATOR ',') AS recipients FROM incomes WHERE date_received >= '$before' AND date_received <= '$after' AND user_id = $uid GROUP BY user_id");
			return $income->fetch();
		}

		public static function getIncomes($uid, $year, $month, $incomeSource) {			
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
			if(!empty($incomeSource)) {
				$src = " AND source='$incomeSource'";
			}
			$pdo = Database::connect();
			$incomes = $pdo->query("SELECT id, user_id, source, description, amount, status, received_from, date_received, DATE_FORMAT(date_received, '%M %d, %Y') AS received_on, created_at FROM incomes WHERE user_id=$uid AND date_received >= '$from' AND date_received <= '$to' $src ORDER BY created_at DESC");
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

		public static function create($user_id, $source, $amount, $received_from, $date_received, $description, $year, $month, $incomeSource) {
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
				return self::getIncomes($user_id, $year, $month, $incomeSource);
			} else {
				return false;
			}
		}

		public static function update($user_id, $source, $amount, $received_from, $date_received, $description, $year, $month, $incomeSource, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$income = $pdo->prepare("UPDATE incomes SET source=?, amount=?, received_from=?, date_received=?, description=?, updated_at=? WHERE id=?");
			 $updated = $income->execute([$source, $amount, $received_from, $date_received, $description, $updated_at, $id]);				
			 if($updated) {
				return self::getIncomes($user_id, $year, $month, $incomeSource);
			 } else {
				return false;
			 }
		}

		public static function delete($id, $uid, $year, $month, $incomeSource) {
			$pdo = Database::connect();
			$income = $pdo->prepare("DELETE FROM incomes WHERE id=?");
			$deleted = $income->execute([$id]);	
			if($deleted) {
				return self::getIncomes($uid, $year, $month, $incomeSource);
			} else {
				return false;
			}
		}
	}
?>