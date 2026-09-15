<?php
	require "../../autoload.php";
    require_once "../../src/Functions/helpers.php";
	header("Content-Type: application/json");

    use App\Controllers\IncomeController;
    use App\Controllers\ExpensesController;
    use App\Controllers\AttendanceController;

	if($_SERVER['REQUEST_METHOD'] === "POST") {
        $income = new IncomeController();
        $expense = new ExpensesController();
        $attendance = new AttendanceController();
        $info = json_decode(file_get_contents("php://input"));
        $year = (string)$info->year;
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
        $janIncome = $janIncome1 = $income->getIncomePerMonth($year, '01', $uid);
        $febIncome = $febIncome1 = $income->getIncomePerMonth($year, '02', $uid);
        $marIncome = $marIncome1 = $income->getIncomePerMonth($year, '03', $uid);
        $aprIncome = $aprIncome1 = $income->getIncomePerMonth($year, '04', $uid);  
        $mayIncome = $mayIncome1 = $income->getIncomePerMonth($year, '05', $uid);
        $junIncome = $junIncome1 = $income->getIncomePerMonth($year, '06', $uid);
        $julIncome = $julIncome1 = $income->getIncomePerMonth($year, '07', $uid);
        $augIncome = $augIncome1 = $income->getIncomePerMonth($year, '08', $uid);
        $sepIncome = $sepIncome1 = $income->getIncomePerMonth($year, '09', $uid);
        $octIncome = $octIncome1 = $income->getIncomePerMonth($year, '10', $uid);
        $novIncome = $novIncome1 = $income->getIncomePerMonth($year, '11', $uid);
        $decIncome = $decIncome1 = $income->getIncomePerMonth($year, '12', $uid);
        $janIncome = $janIncome->total_amount ?? 0;
        $febIncome = $febIncome->total_amount ?? 0;
        $marIncome = $marIncome->total_amount ?? 0;
        $aprIncome = $aprIncome->total_amount ?? 0;
        $mayIncome = $mayIncome->total_amount ?? 0;
        $junIncome = $junIncome->total_amount ?? 0;
        $julIncome = $julIncome->total_amount ?? 0;
        $augIncome = $augIncome->total_amount ?? 0;
        $sepIncome = $sepIncome->total_amount ?? 0;
        $octIncome = $octIncome->total_amount ?? 0;
        $novIncome = $novIncome->total_amount ?? 0;
        $decIncome = $decIncome->total_amount ?? 0;
        $totalIncome = $janIncome + $febIncome + $marIncome + $aprIncome + $mayIncome + $junIncome + $julIncome + $augIncome + $sepIncome + $octIncome + $novIncome + $decIncome;

        // Expenses
        $janExpense = $janExpense1 = $expense->getExpensePerMonth($year, '01', $uid);
        $febExpense = $febExpense1 = $expense->getExpensePerMonth($year, '02', $uid);
        $marExpense = $marExpense1 = $expense->getExpensePerMonth($year, '03', $uid);
        $aprExpense = $aprExpense1 = $expense->getExpensePerMonth($year, '04', $uid);  
        $mayExpense = $mayExpense1 = $expense->getExpensePerMonth($year, '05', $uid);
        $junExpense = $junExpense1 = $expense->getExpensePerMonth($year, '06', $uid);
        $julExpense = $julExpense1 = $expense->getExpensePerMonth($year, '07', $uid);
        $augExpense = $augExpense1 = $expense->getExpensePerMonth($year, '08', $uid);
        $sepExpense = $sepExpense1 = $expense->getExpensePerMonth($year, '09', $uid);
        $octExpense = $octExpense1 = $expense->getExpensePerMonth($year, '10', $uid);
        $novExpense = $novExpense1 = $expense->getExpensePerMonth($year, '11', $uid);
        $decExpense = $decExpense1 = $expense->getExpensePerMonth($year, '12', $uid);
        $janExpense = $janExpense->total_amount ?? 0;
        $febExpense = $febExpense->total_amount ?? 0;
        $marExpense = $marExpense->total_amount ?? 0;
        $aprExpense = $aprExpense->total_amount ?? 0;
        $mayExpense = $mayExpense->total_amount ?? 0;
        $junExpense = $junExpense->total_amount ?? 0;
        $julExpense = $julExpense->total_amount ?? 0;
        $augExpense = $augExpense->total_amount ?? 0;
        $sepExpense = $sepExpense->total_amount ?? 0;
        $octExpense = $octExpense->total_amount ?? 0;
        $novExpense = $novExpense->total_amount ?? 0;
        $decExpense = $decExpense->total_amount ?? 0;
        $totalExpenses = $janExpense + $febExpense + $marExpense + $aprExpense + $mayExpense + $junExpense + $julExpense + $augExpense + $sepExpense + $octExpense + $novExpense + $decExpense;

        // Attendance
        $janAttendance = $attendance->getAttendancePerMonth($year, '01', $uid);
        $febAttendance = $attendance->getAttendancePerMonth($year, '02', $uid);
        $marAttendance = $attendance->getAttendancePerMonth($year, '03', $uid);
        $aprAttendance = $attendance->getAttendancePerMonth($year, '04', $uid);  
        $mayAttendance = $attendance->getAttendancePerMonth($year, '05', $uid);
        $junAttendance = $attendance->getAttendancePerMonth($year, '06', $uid);
        $julAttendance = $attendance->getAttendancePerMonth($year, '07', $uid);
        $augAttendance = $attendance->getAttendancePerMonth($year, '08', $uid);
        $sepAttendance = $attendance->getAttendancePerMonth($year, '09', $uid);
        $octAttendance = $attendance->getAttendancePerMonth($year, '10', $uid);
        $novAttendance = $attendance->getAttendancePerMonth($year, '11', $uid);
        $decAttendance = $attendance->getAttendancePerMonth($year, '12', $uid);
        $janAttendance = $janAttendance['total_attendance'] ?? 0;
        $febAttendance = $febAttendance['total_attendance'] ?? 0;
        $marAttendance = $marAttendance['total_attendance'] ?? 0;
        $aprAttendance = $aprAttendance['total_attendance'] ?? 0;
        $mayAttendance = $mayAttendance['total_attendance'] ?? 0;
        $junAttendance = $junAttendance['total_attendance'] ?? 0;
        $julAttendance = $julAttendance['total_attendance'] ?? 0;
        $augAttendance = $augAttendance['total_attendance'] ?? 0;
        $sepAttendance = $sepAttendance['total_attendance'] ?? 0;
        $octAttendance = $octAttendance['total_attendance'] ?? 0;
        $novAttendance = $novAttendance['total_attendance'] ?? 0;
        $decAttendance = $decAttendance['total_attendance'] ?? 0;
        $totalAttendance = $janAttendance + $febAttendance + $marAttendance + $aprAttendance + $mayAttendance + $junAttendance + $julAttendance + $augAttendance + $sepAttendance + $octAttendance + $novAttendance + $decAttendance;

        $results = [$janIncome, $febIncome, $marIncome, $aprIncome, $mayIncome, $junIncome, $julIncome, $augIncome, $sepIncome, $octIncome, $novIncome, $decIncome, $janExpense, $febExpense, $marExpense, $aprExpense, $mayExpense, $junExpense, $julExpense, $augExpense, $sepExpense, $octExpense, $novExpense, $decExpense, $janAttendance, $febAttendance, $marAttendance, $aprAttendance, $mayAttendance, $junAttendance, $julAttendance, $augAttendance, $sepAttendance, $octAttendance, $novAttendance, $decAttendance];        
        $incomeResult = [$janIncome, $febIncome, $marIncome, $aprIncome, $mayIncome, $junIncome, $julIncome, $augIncome, $sepIncome, $octIncome, $novIncome, $decIncome];        
        $expenseResult = [$janExpense, $febExpense, $marExpense, $aprExpense, $mayExpense, $junExpense, $julExpense, $augExpense, $sepExpense, $octExpense, $novExpense, $decExpense];
        $attendanceResult = [$janAttendance, $febAttendance, $marAttendance, $aprAttendance, $mayAttendance, $junAttendance, $julAttendance, $augAttendance, $sepAttendance, $octAttendance, $novAttendance, $decAttendance];

        $maxValue = max($results);
        $maxValueOfIncome = max($incomeResult);
        $maxValueOfExpense = max($expenseResult);
        $maxValueOfAttendance = max($attendanceResult);

            $allWeeks = [];            
            for($k = 1; $k <= 12; $k++) {         

                // Weekly - Start
                if($selectedMonth !== "all") {    
                    $janDataPerWeek = getMonthWeekDetails($k, $year);
                    $janWeeks = [];
                    $i = 1;
                    $maxValue1 = 0;
                    $details = [];
                    $totalJanIncome = $totalJanExpense = $totalAttendance = [];

                    foreach($janDataPerWeek["weeks"] as $wk) {
                        $before = (string)$wk['start_date'] . " 00:00:00";
                        $after = (string)$wk['last_day'] . " 23:59:59";
                        $janIncPW = $income->getIncomePerWeek($before, $after, $uid);   
                        $details[] = $janIncPW;                         

                        $janIncPW = $janIncPW->total_amount ?? 0;
                        $totalJanIncome[] = $janIncPW;                        
                        
                        $janExpPW = $expense->getExpensePerWeek($before, $after, $uid);
                        $janExpPW = $janExpPW->total_amount ?? 0;
                        $totalJanExpense[] = $janExpPW;

                        $attendancePerWeek = $attendance->getAttendancePerWeek($before, $after, $uid);
                        $attendancePerWeek = $attendancePerWeek['total_attendance'] ?? 0;
                        $totalAttendance[] = $attendancePerWeek;                  

                        $max = max([$janIncPW, $janExpPW, $attendancePerWeek]);
                        if($maxValue1 < $max) {
                            $maxValue1 = $max;
                        }

                        $janWeeks[] = (object)[              
                            "maxValue" => $maxValue1, 
                            "maxValueOfIncome" => max($totalJanIncome),
                            "maxValueOfExpense" => max($totalJanExpense),
                            "maxValueOfAttendance" => max($totalAttendance),
                            "details" => $details,                            
                            "month" => "Week " . $i,
                            "total_income" => array_sum($totalJanIncome),
                            "total_expense" => array_sum($totalJanExpense),
                            "total_attendance" => array_sum($totalAttendance),
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
                                    "value" => $attendancePerWeek, 
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
                    // $janIncome = $janIncome->total_amount ?? 0;
                    // $janExpense = $expense->getExpensePerMonth($year, $k, $uid);
                    // $janExpense = $janExpense->total_amount ?? 0;
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
                "maxValueOfIncome" => $maxValueOfIncome,
                "maxValueOfExpense" => $maxValueOfExpense,
                "maxValueOfAttendance" => $maxValueOfAttendance,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,     
                "total_attendance" => $totalAttendance,               
                "month" => "Jan",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "year" => $year,  
                        "value" => $janIncome, 
                        "details" => $janIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857"
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $janExpense, 
                        "year" => $year,  
                        "details" => $janExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $janAttendance, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]                
            ],
            (object)[
                "maxValue" => $maxValue,
                "maxValueOfIncome" => $maxValueOfIncome,
                "maxValueOfExpense" => $maxValueOfExpense,
                "maxValueOfAttendance" => $maxValueOfAttendance,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "total_attendance" => $totalAttendance,                
                "month" => "Feb",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "year" => $year,  
                        "value" => $febIncome, 
                        "details" => $febIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $febExpense, 
                        "year" => $year,  
                        "details" => $febExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $febAttendance, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "total_attendance" => $totalAttendance,                
                "month" => "Mar",                
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $marIncome, 
                        "year" => $year,  
                        "details" => $marIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $marExpense, 
                        "year" => $year,  
                        "details" => $marExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $marAttendance, 
                        "colorStart" => "#3B82F6", 
                        "colorEnd" => "#1D4ED8" 
                    ]
                ]
            ],
            (object)[
                "maxValue" => $maxValue,
                "total_income" => $totalIncome,
                "total_expense" => $totalExpenses,
                "total_attendance" => $totalAttendance,                
                "month" => "Apr",
                "metrics" => [
                    (object)[
                        "label" => "Income", 
                        "value" => $aprIncome, 
                        "year" => $year,  
                        "details" => $aprIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $aprExpense, 
                        "year" => $year,  
                        "details" => $aprExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $aprAttendance, 
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
                        "year" => $year,           
                        "details" => $mayIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $mayExpense, 
                        "year" => $year,  
                        "details" => $mayExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $mayAttendance, 
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
                        "year" => $year,  
                        "details" => $junIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $junExpense, 
                        "year" => $year,  
                        "details" => $junExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $junAttendance, 
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
                        "year" => $year,  
                        "details" => $julIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $julExpense, 
                        "year" => $year,  
                        "details" => $julExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $julAttendance, 
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
                        "year" => $year, 
                        "details" => $augIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $augExpense, 
                        "year" => $year,  
                        "details" => $augExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $augAttendance, 
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
                        "year" => $year,  
                        "details" => $sepIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $sepExpense, 
                        "year" => $year,  
                        "details" => $sepExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $sepAttendance, 
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
                        "year" => $year,  
                        "details" => $octIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $octExpense, 
                        "year" => $year,  
                        "details" => $octExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $octAttendance, 
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
                        "year" => $year,  
                        "details" => $novIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $novExpense, 
                        "year" => $year,  
                        "details" => $novExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $novAttendance, 
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
                        "year" => $year,    
                        "details" => $decIncome1,
                        "colorStart" => "#10B981", 
                        "colorEnd" => "#047857" 
                    ],      
                    (object)[
                        "label" => "Expenses", 
                        "value" => $decExpense, 
                        "year" => $year,  
                        "details" => $decExpense1,
                        "colorStart" => "#EF4444", 
                        "colorEnd" => "#B91C1C" 
                    ],
                    (object)[
                        "label" => "Attendance", 
                        "value" => $decAttendance, 
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