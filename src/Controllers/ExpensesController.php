<?php	
	namespace App\Controllers;

	use App\Models\Expense;
	use DateTime;

	class ExpensesController {

		public function getData($id) {
			return Expense::getProject($id);
		}

		public function deleteData($id, $uid) {
			return Expense::delete($id, $uid);
		}

		public function changeStatus($id, $status) {
			return Expense::changeStatus($id, $status);					
		}

		public function getExpenses($uid) {
			return Expense::getExpenses($uid);
		}

		private function lastDay($year, $month) {
			$fd = (string)$year.'-'.$month.'-'.(string)date('d');
			$sd = new DateTime($fd);			
			$sd->modify('last day of this month');
			return $sd->format('d');
		}

		public function getExpensePerMonth($year, $month, $uid) {
			$before = $year.'-'.$month.'-01';
			$after = $year.'-'.$month.'-'.$this->lastDay($year, $month);
			return Expense::getExpensePerMonth($before, $after, $uid);
		}
		
		public function store($data) {
			$id = trim(htmlspecialchars($data['id']));
			$user_id = trim(htmlspecialchars($data['user_id']));
			$asset = trim(htmlspecialchars($data['asset']));
			$amount = trim(htmlspecialchars($data['amount']));
			$received_by = trim(htmlspecialchars($data['received_by']));		
            $date_expensed = date('Y-m-d H:i:s', strtotime(trim(htmlspecialchars($data['date_expensed']))));            
			$description = trim(htmlspecialchars($data['description']));
            $receipt_number = trim(htmlspecialchars($data['receipt_number']));
			$mode = trim(htmlspecialchars($data['mode']));

			if($asset AND $amount) {
				if($mode == "add") {
					$inserted = Expense::create($user_id, $asset, $amount, $received_by, $date_expensed, $description, $receipt_number);
					if($inserted) {
						return $inserted;
					} else {
						return false;
					}
				} elseif($mode == "edit") {
					$updated = Expense::update($user_id, $asset, $amount, $received_by, $date_expensed, $description, $receipt_number, $id);
					if($updated) {
						return $updated;
					} else {
						return false;
					}
				}				
			}
		}

		private function isExisting($title, $description) {
			if(Expense::findUserByFields($title, $description)) {
				return true;
			} else {
				return false;
			}
		}
	}
?>
