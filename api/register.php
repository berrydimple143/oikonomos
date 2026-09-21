<?php
	require "../autoload.php";
	require '../vendor/autoload.php';
	require_once '../src/Functions/helpers.php'; 
	header("Content-Type: application/json");
	use App\Controllers\UsersController;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	if($_SERVER['REQUEST_METHOD'] === "POST") {
		$newUser = new UsersController();
		$user = json_decode(file_get_contents("php://input"));		
		$email = $user->email;
		$code = $user->code;
		$siteUrl = $user->siteUrl;
		$data = [
			'organization' => $user->organization,
			'firstname' => $user->firstname,
			'lastname' => $user->lastname,
			'code' => $code,
			'siteUrl' => $siteUrl,
			'email' => $email,
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
		$info = $newUser->store($data);
		if($info) {
			$mail = new PHPMailer(true);
			try {
				$mail->isSMTP();
				$mail->Host       = 'smtp.gmail.com';
				$mail->SMTPAuth   = true;
				$mail->Username   = 'faithfulstewards.admin@gmail.com';
				$mail->Password   = 'fvyy ysci fgfh uxpa';
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail->Port       = 587;
				$mail->setFrom('faithfulstewards.admin@gmail.com', 'Faithful Stewards Registration Confirmation');
				$mail->addAddress($email);
				$mail->addReplyTo('faithfulstewards.admin@gmail.com', 'Virgil T. Rosalita');
				$fname = $user->firstname.' '.$user->lastname;		
				$confirmationLink = $siteUrl."/confirmation.php?code=".$code;	
				$DocsLink = $siteUrl."/documentation.php";	
				$message = <<<HTML
					<!DOCTYPE html>
					<html lang="en">
					<head>
					<meta charset="UTF-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Welcome to Faithful Stewards Online</title>
					</head>
					<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">

					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 40px 0;">
						<tr>
						<td align="center">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
							<tr>
								<td style="background-color: #1E293B; padding: 32px; text-align: center;">
								<span style="font-size: 24px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px;">Faithful Stewards Online</span>
								</td>
							</tr>
							<tr>
								<td style="padding: 40px 32px 32px 32px;">
								<h1 style="margin: 0 0 16px 0; font-size: 24px; font-weight: 700; color: #0f172a; line-height: 1.3;">
									Welcome aboard, $fname! 🎉
								</h1>
								<p style="margin: 0 0 24px 0; font-size: 16px; line-height: 1.6; color: #475569;">
									Thank you for subscribing to **Faithful Stewards Online**! Your account has been successfully created, and your paid subscription is now active.
								</p>
								<p style="margin: 0 0 32px 0; font-size: 16px; line-height: 1.6; color: #475569;">
									To complete your setup and access your dashboard, please confirm your email address below:
								</p>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
									<td align="center" style="padding-bottom: 32px;">
										<a href="$confirmationLink" target="_blank" style="display: inline-block; background-color: #1E293B; color: #ffffff; font-size: 16px; font-weight: 600; padding: 14px 32px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(7f, 70, 229, 0.2);">
										Confirm Email &amp; Launch Dashboard
										</a>
									</td>
									</tr>
								</table>
								<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
									<p style="margin: 0 0 8px 0; font-size: 14px; font-weight: 600; color: #334155;">Account Summary:</p>
									<p style="margin: 0 0 4px 0; font-size: 14px; color: #64748b;">• <strong>Plan:</strong> Pro Tier</p>
									<p style="margin: 0; font-size: 14px; color: #64748b;">• <strong>Account Email:</strong> $email</p>
								</div>
								<p style="margin: 0 0 8px 0; font-size: 12px; color: #94a3b8; line-height: 1.5;">
									Button not working? Copy and paste this link into your browser:
								</p>
								<p style="margin: 0; font-size: 12px; word-break: break-all;">
									<a href="$confirmationLink" style="color: #1E293B; text-decoration: underline;">$confirmationLink</a>
								</p>
								</td>
							</tr>
							<tr>
								<td style="background-color: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0;">
								<p style="margin: 0 0 8px 0; font-size: 13px; color: #64748b;">
									Need help getting started? Check out our <a href="$DocsLink" style="color: #1E293B; text-decoration: none;">Documentation</a> or reply directly to this email to reach support.
								</p>
								<p style="margin: 0; font-size: 12px; color: #94a3b8;">
									&copy; 2026 Faithful Stewards. All rights reserved.
								</p>
								</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>

					</body>
					</html>
				HTML;
				// Content
				$mail->isHTML(true);                                   
				$mail->Subject = "Faithful Stewards Registration Confirmation";
				$mail->Body    = $message;
				$mail->AltBody = $message;
				//$mail->SMTPDebug = 2;

				$mail->send();
				echo json_encode([
					'status' => true,
					'message' => 'Registration confirmation has been sent to your email.',
					'data' => $info 
				]);
			} catch (Exception $e) {
				echo json_encode([
					'status' => false,
					'message' => "Message could not be sent. Mailer Error: $mail->ErrorInfo",
					'data' => $info 
				]);
			}
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