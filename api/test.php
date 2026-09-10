<?php
    require_once "../src/Functions/helpers.php";

    if($_SERVER['REQUEST_METHOD'] === "POST") {	
        $info = json_decode(file_get_contents("php://input"));
        $year = $info->year;
        $results = getMonthWeekDetails(1, $year);
        $last = (string)$results['weeks'][0]["last_day"] . " 23:59:59";
        http_response_code(200);
        echo json_encode([
			"data" => $results,
            "month" => $results['month'],
            "total_weeks" => $results['total_weeks'],
            "weeks" => $results['weeks'],
            "start_date" => $results['weeks'][0]["start_date"],
            "last_day" => $last
		]);
    } else {
		http_response_code(405);
		echo json_encode([
			'status' => false,
			'message' => 'Only POST requests are allowed.',
			'data' => []
		]);
	}
?>