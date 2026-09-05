<?php
	require "../../autoload.php";
	header("Content-Type: application/json");

    use App\Controllers\ExpensesController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {
        $expense = new ExpensesController();
        $info = json_decode(file_get_contents("php://input"));
        //$year = (string)$info->year;
        $year = (string)date('Y');
        $janExpense = $expense->getExpensePerMonth($year, '01');
        $febExpense = $expense->getExpensePerMonth($year, '02');
        $marExpense = $expense->getExpensePerMonth($year, '03');
        $aprExpense = $expense->getExpensePerMonth($year, '04');  
        $mayExpense = $expense->getExpensePerMonth($year, '05');
        $junExpense = $expense->getExpensePerMonth($year, '06');
        $julExpense = $expense->getExpensePerMonth($year, '07');
        $augExpense = $expense->getExpensePerMonth($year, '08');
        $sepExpense = $expense->getExpensePerMonth($year, '09');
        $octExpense = $expense->getExpensePerMonth($year, '10');
        $novExpense = $expense->getExpensePerMonth($year, '11');
        $decExpense = $expense->getExpensePerMonth($year, '12');
        $jan = $janExpense['total_amount'] ?? 0;
        $feb = $febExpense['total_amount'] ?? 0;
        $mar = $marExpense['total_amount'] ?? 0;
        $apr = $aprExpense['total_amount'] ?? 0;
        $may = $mayExpense['total_amount'] ?? 0;
        $jun = $junExpense['total_amount'] ?? 0;
        $jul = $julExpense['total_amount'] ?? 0;
        $aug = $augExpense['total_amount'] ?? 0;
        $sep = $sepExpense['total_amount'] ?? 0;
        $oct = $octExpense['total_amount'] ?? 0;
        $nov = $novExpense['total_amount'] ?? 0;
        $dec = $decExpense['total_amount'] ?? 0;
        $total = $jan + $feb + $mar + $apr + $may + $jun + $jul + $aug + $sep + $oct + $nov + $dec;
        echo json_encode([
            'status' => true,
            'message' => 'success',
            'janExpense' => $jan,
            'febExpense' => $feb,
            'marExpense' => $mar,
            'aprExpense' => $apr,
            'mayExpense' => $may,
            'junExpense' => $jun,
            'julExpense' => $jul,
            'augExpense' => $aug,
            'sepExpense' => $sep,
            'octExpense' => $oct,
            'novExpense' => $nov,
            'decExpense' => $dec,
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