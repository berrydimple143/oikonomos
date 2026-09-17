<?php
	namespace App\Models;

	use App\Core\Database;
	use PDO;
	use App\Functions\Utilities;

	class Attendance {	

		public static function getAttendanceWithDates($before, $after, $uid) {
			$pdo = Database::connect();			
			$attendance = $pdo->query("SELECT SUM(quantity) as total_attendance, GROUP_CONCAT(date_attended SEPARATOR ',') AS dates_attended, GROUP_CONCAT(quantity SEPARATOR ',') AS quantities, GROUP_CONCAT(classification SEPARATOR ',') AS classifications FROM attendances WHERE date_attended >= '$before' AND date_attended <= '$after' AND user_id = $uid GROUP BY user_id");
			return $attendance->fetch(PDO::FETCH_OBJ);
		}

		public static function getAttendances($uid, $year, $month) {			
			if(empty($month)) {
				$from = $year."-01-01 00:00:00";
				$to = $year."-12-31 23:59:59";
			} else {
				$m = Utilities::getNumberMonth($month);	
				$day = Utilities::getLastDaysOfYearMonth($year, $m[1]);							
				$from = $year."-".$m[0]."-01 00:00:00";
				$to = $year."-".$m[0]."-".$day." 23:59:59";
			}
			$pdo = Database::connect();
			$attendances = $pdo->query("SELECT id, user_id, quantity, description, classification, status, date_attended, DATE_FORMAT(date_attended, '%M %d, %Y') AS attended_on, created_at FROM attendances WHERE user_id=$uid AND date_attended >= '$from' AND date_attended <= '$to' ORDER BY created_at DESC");
			return $attendances->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getAttendance($id) {
			$pdo = Database::connect();
			$attendance = $pdo->query("SELECT * FROM attendances WHERE id=$id");
			return $attendance->fetch(PDO::FETCH_OBJ);
		}
        
		public static function changeStatus($id, $status) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$experience = $pdo->prepare("UPDATE experiences SET status=?, updated_at=? WHERE id=?");
			return $experience->execute([$status, $updated_at, $id]);
		}

		public static function create($user_id, $quantity, $classification, $date_attended, $description, $year, $month) {
			$pdo = Database::connect();
			$experience = $pdo->prepare("INSERT INTO attendances(user_id, quantity, classification, date_attended, description) VALUES(:user_id, :quantity, :classification, :date_attended, :description)");
			$inserted = $experience->execute([
				":user_id" => $user_id,
				":quantity" => $quantity,
				":classification" => $classification,
				":date_attended" => $date_attended,
				":description" => $description
			]);

			if($inserted) {				
				return self::getAttendances($user_id, $year, $month);
			} else {
				return false;
			}
		}

		public static function update($user_id, $quantity, $classification, $date_attended, $description, $year, $month, $id) {
			$pdo = Database::connect();
			$updated_at = date('Y-m-d H:i:s');
			$attendance = $pdo->prepare("UPDATE attendances SET quantity=?, classification=?, date_attended=?, description=?, updated_at=? WHERE id=?");
			 $updated = $attendance->execute([$quantity, $classification, $date_attended, $description, $updated_at, $id]);				
			 if($updated) {
				return self::getAttendances($user_id, $year, $month);
			 } else {
				return false;
			 }
		}

		public static function delete($id, $uid, $year, $month) {
			$pdo = Database::connect();
			$attendance = $pdo->prepare("DELETE FROM attendances WHERE id=?");
			$deleted = $attendance->execute([$id]);	
			if($deleted) {
				return self::getAttendances($uid, $year, $month);
			} else {
				return false;
			}
		}
	}
?>