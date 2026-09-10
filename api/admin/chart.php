<?php
	require "../../autoload.php";
    require_once "../../src/Functions/helpers.php";
	header("Content-Type: application/json");

    use App\Controllers\IncomeController;
    use App\Controllers\ExpensesController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {
        $income = new IncomeController();
        $expense = new ExpensesController();
        $info = json_decode(file_get_contents("php://input"));
        $year = (string)$info->year;
        //$year = (string)date('Y');
        $uid = $info->user_id;
        $selectedMonth = $info->selectedMonth;
        if(empty($uid) && empty($year)) {
            echo json_encode([
                'status' => false,
                'message' => "User ID and Year is required."
            ]);
            exit();
        }
        // Incomes
        $janIncome = $income->getIncomePerMonth($year, '01', $uid);
        $febIncome = $income->getIncomePerMonth($year, '02', $uid);
        $marIncome = $income->getIncomePerMonth($year, '03', $uid);
        $aprIncome = $income->getIncomePerMonth($year, '04', $uid);  
        $mayIncome = $income->getIncomePerMonth($year, '05', $uid);
        $junIncome = $income->getIncomePerMonth($year, '06', $uid);
        $julIncome = $income->getIncomePerMonth($year, '07', $uid);
        $augIncome = $income->getIncomePerMonth($year, '08', $uid);
        $sepIncome = $income->getIncomePerMonth($year, '09', $uid);
        $octIncome = $income->getIncomePerMonth($year, '10', $uid);
        $novIncome = $income->getIncomePerMonth($year, '11', $uid);
        $decIncome = $income->getIncomePerMonth($year, '12', $uid);
        $janIncome = $janIncome['total_amount'] ?? 0;
        $febIncome = $febIncome['total_amount'] ?? 0;
        $marIncome = $marIncome['total_amount'] ?? 0;
        $aprIncome = $aprIncome['total_amount'] ?? 0;
        $mayIncome = $mayIncome['total_amount'] ?? 0;
        $junIncome = $junIncome['total_amount'] ?? 0;
        $julIncome = $julIncome['total_amount'] ?? 0;
        $augIncome = $augIncome['total_amount'] ?? 0;
        $sepIncome = $sepIncome['total_amount'] ?? 0;
        $octIncome = $octIncome['total_amount'] ?? 0;
        $novIncome = $novIncome['total_amount'] ?? 0;
        $decIncome = $decIncome['total_amount'] ?? 0;
        $totalIncome = $janIncome + $febIncome + $marIncome + $aprIncome + $mayIncome + $junIncome + $julIncome + $augIncome + $sepIncome + $octIncome + $novIncome + $decIncome;

        // Expenses
        $janExpense = $expense->getExpensePerMonth($year, '01', $uid);
        $febExpense = $expense->getExpensePerMonth($year, '02', $uid);
        $marExpense = $expense->getExpensePerMonth($year, '03', $uid);
        $aprExpense = $expense->getExpensePerMonth($year, '04', $uid);  
        $mayExpense = $expense->getExpensePerMonth($year, '05', $uid);
        $junExpense = $expense->getExpensePerMonth($year, '06', $uid);
        $julExpense = $expense->getExpensePerMonth($year, '07', $uid);
        $augExpense = $expense->getExpensePerMonth($year, '08', $uid);
        $sepExpense = $expense->getExpensePerMonth($year, '09', $uid);
        $octExpense = $expense->getExpensePerMonth($year, '10', $uid);
        $novExpense = $expense->getExpensePerMonth($year, '11', $uid);
        $decExpense = $expense->getExpensePerMonth($year, '12', $uid);
        $janExpense = $janExpense['total_amount'] ?? 0;
        $febExpense = $febExpense['total_amount'] ?? 0;
        $marExpense = $marExpense['total_amount'] ?? 0;
        $aprExpense = $aprExpense['total_amount'] ?? 0;
        $mayExpense = $mayExpense['total_amount'] ?? 0;
        $junExpense = $junExpense['total_amount'] ?? 0;
        $julExpense = $julExpense['total_amount'] ?? 0;
        $augExpense = $augExpense['total_amount'] ?? 0;
        $sepExpense = $sepExpense['total_amount'] ?? 0;
        $octExpense = $octExpense['total_amount'] ?? 0;
        $novExpense = $novExpense['total_amount'] ?? 0;
        $decExpense = $decExpense['total_amount'] ?? 0;
        $totalExpenses = $janExpense + $febExpense + $marExpense + $aprExpense + $mayExpense + $junExpense + $julExpense + $augExpense + $sepExpense + $octExpense + $novExpense + $decExpense;

        $results = [$janIncome, $febIncome, $marIncome, $aprIncome, $mayIncome, $junIncome, $julIncome, $augIncome, $sepIncome, $octIncome, $novIncome, $decIncome, $janExpense, $febExpense, $marExpense, $aprExpense, $mayExpense, $junExpense, $julExpense, $augExpense, $sepExpense, $octExpense, $novExpense, $decExpense];
        $maxValue = max($results);

        
            
            $allWeeks = [];            
            for($k = 1; $k <= 12; $k++) {         

                // Weekly - Start
                if($selectedMonth !== "all") {    
                    $janDataPerWeek = getMonthWeekDetails($k, $year);
                    $janWeeks = [];
                    $i = 1;
                    $maxValue1 = 0;
                    $totalJanIncome = $totalJanExpense = [];

                    foreach($janDataPerWeek["weeks"] as $wk) {
                        $before = (string)$wk['start_date'] . " 00:00:00";
                        $after = (string)$wk['last_day'] . " 23:59:59";
                        $janIncPW = $income->getIncomePerWeek($before, $after, $uid);
                        $janIncPW = $janIncPW['total_amount'] ?? 0;
                        $totalJanIncome[] = $janIncPW;
                        
                        $janExpPW = $expense->getExpensePerWeek($before, $after, $uid);
                        $janExpPW = $janExpPW['total_amount'] ?? 0;
                        $totalJanExpense[] = $janExpPW;

                        $max = max([$janIncPW, $janExpPW]);
                        if($maxValue1 < $max) {
                            $maxValue1 = $max;
                        }                                        

                        $janWeeks[] = (object)[              
                            "maxValue" => $maxValue1, 
                            "month" => "Week " . $i,
                            "total_income" => array_sum($totalJanIncome),
                            "total_expense" => array_sum($totalJanExpense),
                            "metrics" => [
                                (object)[
                                    "label" => "Income", 
                                    "value" => $janIncPW, 
                                    "start_date" => $before,
                                    "end_date" => $after,
                                    "colorStart" => "#10B981", 
                                    "colorEnd" => "#047857"
                                ],      
                                (object)[
                                    "label" => "Expenses", 
                                    "value" => $janExpPW, 
                                    "start_date" => $before,
                                    "end_date" => $after,
                                    "colorStart" => "#EF4444", 
                                    "colorEnd" => "#B91C1C" 
                                ],
                                (object)[
                                    "label" => "Attendance", 
                                    "value" => 35, 
                                    "start_date" => $before,
                                    "end_date" => $after,
                                    "colorStart" => "#3B82F6", 
                                    "colorEnd" => "#1D4ED8" 
                                ]
                            ]
                        ];
                        $i++;
                    }                  

                    $allWeeks[] = $janWeeks; // Weekly - End
                } else {
                    // $month = 'Jan';
                    // if($k == 2) {
                    //     $month = 'Feb';
                    // } elseif($k == 3) {

                    // }

                    // if($k <= 9) {
                    //     $k = '0'.(string)$k;
                    // }
                    // $janIncome = $income->getIncomePerMonth($year, $k, $uid);
                    // $janIncome = $janIncome['total_amount'] ?? 0;
                    // $janExpense = $expense->getExpensePerMonth($year, $k, $uid);
                    // $janExpense = $janExpense['total_amount'] ?? 0;
                    // $maxResult = [$janIncome, $janExpense];
                    

                    // $janWeeks[] = (object)[              
                    //     "maxValue" => max($maxResult), 
                    //     "month" => $month,
                    //     "total_income" => array_sum($totalJanIncome),
                    //     "total_expense" => array_sum($totalJanExpense),
                    //     "metrics" => [
                    //         (object)[
                    //             "label" => "Income", 
                    //             "value" => $janIncPW, 
                    //             "start_date" => $before,
                    //             "end_date" => $after,
                    //             "colorStart" => "#10B981", 
                    //             "colorEnd" => "#047857"
                    //         ],      
                    //         (object)[
                    //             "label" => "Expenses", 
                    //             "value" => $janExpPW, 
                    //             "start_date" => $before,
                    //             "end_date" => $after,
                    //             "colorStart" => "#EF4444", 
                    //             "colorEnd" => "#B91C1C" 
                    //         ],
                    //         (object)[
                    //             "label" => "Attendance", 
                    //             "value" => 35, 
                    //             "start_date" => $before,
                    //             "end_date" => $after,
                    //             "colorStart" => "#3B82F6", 
                    //             "colorEnd" => "#1D4ED8" 
                    //         ]
                    //     ]
                    // ];
                }            
            }

        $defaultData = [
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,                
                "month" => "Jan",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $janIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857"
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $janExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 35, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]                
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Feb",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $febIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $febExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 45, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Mar",                
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $marIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $marExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 100, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Apr",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $aprIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $aprExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 150, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "May",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $mayIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $mayExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 200, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Jun",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $junIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $junExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 90, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Jul",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $julIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $julExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 80, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Aug",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $augIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $augExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 70, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Sep",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $sepIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $sepExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 87, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Oct",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $octIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $octExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 44, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Nov",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $novIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $novExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 96, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "month" => "Dec",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $decIncome, 
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $decExpense, 
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => 170, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ]
        ];

        if($selectedMonth == "Jan") {
            $defaultData = $allWeeks[0];
        } elseif($selectedMonth == "Feb") {
            $defaultData = $allWeeks[1];
        } elseif($selectedMonth == "Mar") {
            $defaultData = $allWeeks[2];
        } elseif($selectedMonth == "Apr") {
            $defaultData = $allWeeks[3];
        } elseif($selectedMonth == "May") {
            $defaultData = $allWeeks[4];
        } elseif($selectedMonth == "Jun") {
            $defaultData = $allWeeks[5];
        } elseif($selectedMonth == "Jul") {
            $defaultData = $allWeeks[6];
        } elseif($selectedMonth == "Aug") {
            $defaultData = $allWeeks[7];
        } elseif($selectedMonth == "Sep") {
            $defaultData = $allWeeks[8];
        } elseif($selectedMonth == "Oct") {
            $defaultData = $allWeeks[9];
        } elseif($selectedMonth == "Nov") {
            $defaultData = $allWeeks[10];
        } elseif($selectedMonth == "Dec") {
            $defaultData = $allWeeks[11];
        }

        echo json_encode($defaultData);
	} else {
		http_response_code(405);
		echo json_encode([
			'status' => false,
			'message' => 'Only POST requests are allowed.',
			'data' => []
		]);
	} 
?>