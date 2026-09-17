<?php
	namespace App\Functions;

    use DateTime;

	class Utilities {

        public static function getWordMonth(int $m): string {
            if($m == 1) {
                return "January";
            } elseif($m == 2) {
                return "February";
            } elseif($m == 3) {
                return "March";
            } elseif($m == 4) {
                return "April";
            } elseif($m == 5) {
                return "May";
            } elseif($m == 6) {
                return "June";
            } elseif($m == 7) {
                return "July";
            } elseif($m == 8) {
                return "August";
            } elseif($m == 9) {
                return "September";
            } elseif($m == 10) {
                return "October";
            } elseif($m == 11) {
                return "November";
            } elseif($m == 12) {
                return "December";
            }
        }
        /**
         * Generates an array of last days for each month in a given year using DateTime.
         *
         * @param int $year
         * @return array
         */
        public static function getLastDaysOfYearMonth(int $year, int $month) {
            //$lastDays = [];

            // Loop through months 1 through 12
            // for($month = 1; $month <= 12; $month++) {
            //     // Create a DateTime object set to the 1st of the month
            //     // "t" format modifier automatically gets the total number of days in that month
            //     $date = DateTime::createFromFormat('Y-n-j', "{$year}-{$month}-1");
                
            //     $lastDays[] = [
            //         'month_number' => (int) $date->format('n'),
            //         'month_name'   => $date->format('F'),
            //         'days_in_month' => (int) $date->format('t'),
            //         'last_day_date' => $date->format('Y-m-t'), // YYYY-MM-DD format of the last day
            //     ];
            // }
            // return $lastDays;
            $date = DateTime::createFromFormat('Y-n-j', "{$year}-{$month}-1");
            return (int)$date->format('t');
        }

        public static function getNumberMonth(string $month): array {
            if($month == 'January') {
                return ['01', 1];
            } elseif($month == 'February') {
                return ['02', 2];
            } elseif($month == 'March') {
                return ['03', 3];
            } elseif($month == 'April') {
                return ['04', 4];
            } elseif($month == 'May') {
                return ['05', 5];
            } elseif($month == 'June') {
                return ['06', 6];
            } elseif($month == 'July') {
                return ['07', 7];
            } elseif($month == 'August') {
                return ['08', 8];
            } elseif($month == 'September') {
                return ['09', 9];
            } elseif($month == 'October') {
                return ['10', 10];
            } elseif($month == 'November') {
                return ['11', 11];
            } elseif($month == 'December') {
                return ['12', 12];
            }
        }
	}

?>