
<?php
	require "../../autoload.php";
	header("Content-Type: application/json");	
	use App\Controllers\ExpensesController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {		
		$input = json_decode(file_get_contents("php://input"));
		$mode = $input->mode;
        $data = [
			'id' => $input->id,			
			'user_id' => $input->user_id,
			'asset' => $input->asset,			
			'amount' => $input->amount,
            'mode' => $mode
		];
		foreach($data as $key => $value) {
			if(empty($value)) {
				$keyname = ucfirst($key);
				echo json_encode([
					'status' => false,
					'message' => "$keyname is required."
				]);
				exit();
			}
		}
		$data['status'] = $input->status;
		$data['received_by'] = $input->received_by;
		$data['date_expensed'] = $input->date_expensed;
		$data['description'] = $input->description;
        $data['receipt_number'] = $input->receipt_number;
		$data['year'] = $input->year;
		$data['month'] = $input->month;
		$data['expenseSource'] = $input->expenseSource;

		$controller = new ExpensesController();
        if($mode == 'add' || $mode == 'edit') {
            $info = $controller->store($data);
		} elseif($mode == 'getAll') {
			$info = $controller->getExpenses($input->user_id, $input->year, $input->month, $input->expenseSource);
		} elseif($mode == 'delete') {
			$info = $controller->deleteData($input->id, $input->user_id, $input->year, $input->month, $input->expenseSource);
		} elseif($mode == 'search') {
			$info = $controller->getData($input->id);
		} elseif($mode == 'change') {
			$info = $controller->changeStatus($input->id, $input->status);
		}
        if($info) {
			http_response_code(200);
			echo json_encode([
				'status' => true,
				'message' => 'Authentication successful.',
				'data' => $info
			]);
		} else {
			http_response_code(401);
			echo json_encode([
				'status' => false,
				'message' => 'Authentication failed.',
				'data' => []
			]);
		}
	} else {
		http_response_code(405);
		echo json_encode([
			'status' => false,
			'message' => 'Only POST requests are allowed.',
			'data' => []
		]);
	} 
?>