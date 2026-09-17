<?php
	require "../../autoload.php";
	header("Content-Type: application/json");
	use App\Controllers\UsersController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {
		$newUser = new UsersController();
		$user = json_decode(file_get_contents("php://input"));
        $mode = $user->mode;
		$data = [
			'user_id' => $user->user_id,
			'currency' => $user->currency,
			'old_password' => $user->old_password,
			'new_password' => $user->new_password,
			'user_password' => $user->user_password,
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
		$info = [];
        if($mode == "editCurrency") {
            $info = $newUser->updateCurrency($data);
        } elseif($mode == "getCurrency") {
            $info = $newUser->getCurrency($data);
		} elseif($mode == "changePassword") {
			$pass = trim(htmlspecialchars($user->old_password));
			if(password_verify($pass, $user->user_password)) {
				$info = $newUser->changePassword($data);		
				http_response_code(200);
				echo json_encode([
					'status' => true,
					'message' => "Password was updated successfully.",
					'data' => $info
				]);
			} else {
				http_response_code(401);
				echo json_encode([
					'status' => false,
					'message' => 'Current password is incorrect!',
					'data' => [] 
				]);
			}
        }		
		if($mode != "changePassword") {
			if($info) {
				http_response_code(200);
				echo json_encode([
					'status' => true,
					'message' => "Authentication successful.",
					'data' => $info
				]);
			} else {
				http_response_code(401);
				echo json_encode([
					'status' => false,
					'message' => "Authentication failed.",
					'data' => $info
				]);
			}
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