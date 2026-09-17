<?php
    if(!function_exists('includeWithArgs') || !function_exists('truncateText') || !function_exists('getFullUrl') || !function_exists('getMonthWeekDetails') || !function_exists('convertDateToString')) {

        function includeWithArgs($filePath, $args = []) {
            if (file_exists($filePath)) {
                // Extract array keys into local variables
                extract($args); 
                include $filePath;
            }
        }

        function truncateText($text, $limit) {
            $short_text = $text;
            if (strlen($text) > $limit) {
                // Cut the text, then find the position of the last space to avoid cutting a word
                $short_text = substr($text, 0, $limit);
                $short_text = substr($short_text, 0, strrpos($short_text, ' ')) . '...';
            }
            return $short_text;
        }

        function getFullUrl($param) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $uri = $_SERVER['REQUEST_URI'];
            $full_url = $protocol . '://' . $host . $uri;
            $type = "/admin/";
            if($param == "income") {
                $type = "/admin/income/";
            } elseif($param == "expense") {
                $type = "/admin/expense/";
            } elseif($param == "attendance") {
                $type = "/admin/attendance/";
            } elseif($param == "projection") {
                $type = "/admin/projection/";
            } elseif($param == "expense_form") {
                $type = "/admin/expense_form/";
            } elseif($param == "income_form") {
                $type = "/admin/income_form/";
            } elseif($param == "attendance_form") {
                $type = "/admin/attendance_form/";
            }
            return str_replace($type, "", $full_url);
        }

        function convertDateToString($d, $fmt) {
            $dt = new DateTime($d);
            return $dt->format($fmt);
        }

        /**
         * Calculates week details and last day of each week for a given month and year.
         * 
         * @param int $month Month number (1-12)
         * @param int $year  Four-digit year (e.g., 2024, 2026)
         * @return array
         */
        function getMonthWeekDetails(int $month, int $year): array {
            // 1. Identify total days in month (automatically handles leap year for Feb)
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $weeks = [];
            $currentWeekNumber = 1;
            $weekStartDay = 1;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Create DateTime instance for current day
                $date = new DateTime(sprintf('%04d-%02d-%02d', $year, $month, $day));
                
                // N = ISO-8601 day of the week (1 for Monday, 7 for Sunday)
                $dayOfWeek = (int)$date->format('N');

                // Check if current day is Sunday or the last day of the month
                if ($dayOfWeek === 7 || $day === $daysInMonth) {
                    $weeks[] = [
                        'week_number' => $currentWeekNumber,
                        'start_date'  => sprintf('%04d-%02d-%02d', $year, $month, $weekStartDay),
                        'last_day'    => $date->format('Y-m-d'),
                        'day_name'    => $date->format('l'),
                    ];

                    // Prepare for next week iteration
                    $currentWeekNumber++;
                    $weekStartDay = $day + 1;
                }
            }

            return [
                'month'       => DateTime::createFromFormat('!m', $month)->format('F'),
                'year'        => $year,
                'total_weeks' => count($weeks),
                'weeks'       => $weeks,
            ];
        }       

        /**
         * Generates the week breakdown for all 12 months of a specific year.
         * 
         * @param int $year Four-digit year
         * @return array
         */
        // function getYearlyWeekBreakdown(int $year, int $month): array {
        //     $yearlyData = [];
        //     for ($month = 1; $month <= 12; $month++) {
        //         $yearlyData[] = getMonthWeekDetails($month, $year);
        //     }
        //     return $yearlyData;
        //     return getMonthWeekDetails($month, $year);
        // }
        
    }
?>