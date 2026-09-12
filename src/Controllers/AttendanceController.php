<?php	
	namespace App\Controllers;

	use App\Models\Attendance;
	use DateTime;

	class AttendanceController {

		public function getData($id) {
			return Attendance::getProject($id);
		}

		public function deleteData($id, $uid, $year, $month) {
			return Attendance::delete($id, $uid, $year, $month);
		}

		public function changeStatus($id, $status) {
			return Attendance::changeStatus($id, $status);					
		}

		public function getAttendances($uid, $year, $month) {
			return Attendance::getAttendances($uid, $year, $month);
		}

		private function lastDay($year, $month) {
			$fd = (string)$year.'-'.$month.'-'.(string)date('d');
			$sd = new DateTime($fd);			
			$sd->modify('last day of this month');
			return $sd->format('d');
		}

		public function getAttendancePerMonth($year, $month, $uid) {
			$before = $year.'-'.$month.'-01';
			$after = $year.'-'.$month.'-'.$this->lastDay($year, $month);
			return Attendance::getAttendanceWithDates($before, $after, $uid);
		}

		public function getAttendancePerWeek($before, $after, $uid) {
			return Attendance::getAttendanceWithDates($before, $after, $uid);
		}
		
		public function store($data) {
			$id = trim(htmlspecialchars($data['id']));
			$user_id = trim(htmlspecialchars($data['user_id']));
			$quantity = trim(htmlspecialchars($data['quantity']));
			$classification = trim(htmlspecialchars($data['classification']));	
            $date_attended = date('Y-m-d H:i:s', strtotime(trim(htmlspecialchars($data['date_attended']))));            
			$description = trim(htmlspecialchars($data['description']));
			$year = trim(htmlspecialchars($data['year']));
			$month = trim(htmlspecialchars($data['month']));
			$mode = trim(htmlspecialchars($data['mode']));

			if($quantity AND $classification) {
				if($mode == "add") {
					$inserted = Attendance::create($user_id, $quantity, $classification, $date_attended, $description, $year, $month);
					if($inserted) {
						return $inserted;
					} else {
						return false;
					}
				} elseif($mode == "edit") {
					$updated = Attendance::update($user_id, $quantity, $classification, $date_attended, $description, $year, $month, $id);
					if($updated) {
						return $updated;
					} else {
						return false;
					}
				}				
			}
		}
	}
?>
