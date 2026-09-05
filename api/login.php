<?php
	require "../autoload.php";
	header("Content-Type: application/json");
	use App\Controllers\AuthController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {		
		$user = json_decode(file_get_contents("php://input"));
		$data = [
			'email' => $user->email,
			'password' => $user->password				
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
		$authUser = new AuthController();
		$account = $authUser->auth($data);
		if($account) {
			http_response_code(200);
			echo json_encode([
				'status' => true,
				'message' => 'Authentication successful.',
				'user' => $account
			]);			
		} else {
			http_response_code(401);
			echo json_encode([
				'status' => false,
				'message' => 'Authentication failed.',
				'user' => []
			]);
		}
	} else {
		http_response_code(405);
		echo json_encode([
			'status' => false,
			'message' => 'Only POST requests are allowed.',
			'user' => []
		]);
	} 
?>