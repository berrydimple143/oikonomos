<?php
	
	namespace App\Controllers;
	use App\Models\User;

	class AuthController {

		public function auth($data) {
			$email = trim(htmlspecialchars($data['email']));
			$password = trim(htmlspecialchars($data['password']));			

			if($email AND $password) {
				$user = User::findUserByEmail($email);				
				if($user) {
					if(password_verify($password, $user->password)) {
						return $user;
					}
					return false;
				}
				return false;
			}
			return false;
		}

	}
?>