<?php
	require "../../autoload.php";
	header("Content-Type: application/json");

    use App\Controllers\IncomeController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {
        $income = new IncomeController();
        $info = json_decode(file_get_contents("php://input"));
        //$year = (string)$info->year;
        $year = (string)date('Y');
        $janIncome = $income->getIncomePerMonth($year, '01');
        $febIncome = $income->getIncomePerMonth($year, '02');
        $marIncome = $income->getIncomePerMonth($year, '03');
        $aprIncome = $income->getIncomePerMonth($year, '04');  
        $mayIncome = $income->getIncomePerMonth($year, '05');
        $junIncome = $income->getIncomePerMonth($year, '06');
        $julIncome = $income->getIncomePerMonth($year, '07');
        $augIncome = $income->getIncomePerMonth($year, '08');
        $sepIncome = $income->getIncomePerMonth($year, '09');
        $octIncome = $income->getIncomePerMonth($year, '10');
        $novIncome = $income->getIncomePerMonth($year, '11');
        $decIncome = $income->getIncomePerMonth($year, '12');
        $jan = $janIncome['total_amount'] ?? 0;
        $feb = $febIncome['total_amount'] ?? 0;
        $mar = $marIncome['total_amount'] ?? 0;
        $apr = $aprIncome['total_amount'] ?? 0;
        $may = $mayIncome['total_amount'] ?? 0;
        $jun = $junIncome['total_amount'] ?? 0;
        $jul = $julIncome['total_amount'] ?? 0;
        $aug = $augIncome['total_amount'] ?? 0;
        $sep = $sepIncome['total_amount'] ?? 0;
        $oct = $octIncome['total_amount'] ?? 0;
        $nov = $novIncome['total_amount'] ?? 0;
        $dec = $decIncome['total_amount'] ?? 0;
        $total = $jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct + $nov + $dec;
        echo json_encode([
            'status' => true,
            'message' => 'success',
            'janIncome' => $jan,
            'febIncome' => $feb,
            'marIncome' => $mar,
            'aprIncome' => $apr,
            'mayIncome' => $may,
            'junIncome' => $jun,
            'julIncome' => $jul,
            'augIncome' => $aug,
            'sepIncome' => $sep,
            'octIncome' => $oct,
            'novIncome' => $nov,
            'decIncome' => $dec,
            'total' => $total
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