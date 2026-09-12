
<?php
	require "../../autoload.php";
	header("Content-Type: application/json");	
	use App\Controllers\AttendanceController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {		
		$input = json_decode(file_get_contents("php://input"));
		$mode = $input->mode;
        $data = [
			'id' => $input->id,			
			'user_id' => $input->user_id,
			'quantity' => $input->quantity,			
			'classification' => $input->classification,
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
		$data['date_attended'] = $input->date_attended;
		$data['description'] = $input->description;
		$data['year'] = $input->year;
		$data['month'] = $input->month;

		$controller = new AttendanceController();
        if($mode == 'add' || $mode == 'edit') {
            $info = $controller->store($data);
		} elseif($mode == 'getAll') {
			$info = $controller->getAttendances($input->user_id, $input->year, $input->month);
		} elseif($mode == 'delete') {
			$info = $controller->deleteData($input->id, $input->user_id, $input->year, $input->month);
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