<?php	
	namespace App\Controllers;

	use App\Models\Income;
	use DateTime;

	class IncomeController {

		public function getData($id) {
			return Income::getProject($id);
		}

		public function deleteData($id, $uid, $year, $month) {
			return Income::delete($id, $uid, $year, $month);
		}

		public function changeStatus($id, $status) {
			return Income::changeStatus($id, $status);					
		}

		public function getIncomes($uid, $year, $month) {
			return Income::getIncomes($uid, $year, $month);
		}

		private function lastDay($year, $month) {
			$fd = (string)$year.'-'.$month.'-'.(string)date('d');
			$sd = new DateTime($fd);			
			$sd->modify('last day of this month');
			return $sd->format('d');
		}

		public function getIncomePerMonth($year, $month, $uid) {
			$before = $year.'-'.$month.'-01';
			$after = $year.'-'.$month.'-'.$this->lastDay($year, $month);
			return Income::getIncomeWithDates($before, $after, $uid);
		}

		public function getIncomePerWeek($before, $after, $uid) {
			return Income::getIncomeWithDates($before, $after, $uid);
		}
		
		public function store($data) {
			$id = trim(htmlspecialchars($data['id']));
			$user_id = trim(htmlspecialchars($data['user_id']));
			$source = trim(htmlspecialchars($data['source']));
			$amount = trim(htmlspecialchars($data['amount']));
			$received_from = trim(htmlspecialchars($data['received_from']));		
            $date_received = date('Y-m-d H:i:s', strtotime(trim(htmlspecialchars($data['date_received']))));            
			$description = trim(htmlspecialchars($data['description']));
			$year = trim(htmlspecialchars($data['year']));
			$month = trim(htmlspecialchars($data['month']));
			$mode = trim(htmlspecialchars($data['mode']));

			if($source AND $amount) {
				if($mode == "add") {
					$inserted = Income::create($user_id, $source, $amount, $received_from, $date_received, $description, $year, $month);
					if($inserted) {
						return $inserted;
					} else {
						return false;
					}
				} elseif($mode == "edit") {
					$updated = Income::update($user_id, $source, $amount, $received_from, $date_received, $description, $year, $month, $id);
					if($updated) {
						return $updated;
					} else {
						return false;
					}
				}				
			}
		}

		private function isExisting($title, $description) {
			if(Income::findUserByFields($title, $description)) {
				return true;
			} else {
				return false;
			}
		}
	}
?>
