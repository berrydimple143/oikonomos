<?php
	namespace App\Core;

	use PDO;
	use PDOException;

	class Database {
		private static $pdo;

		public static function connect() {
			if(!self::$pdo) {
				try {
					self::$pdo = new PDO("mysql:host=localhost;dbname=oikonomos;", "root", "");
				} catch(PDOException $e) {
					die('Database connection error.'. $e->getMessage());
				}
			}
			return self::$pdo;
		}
	}

?>