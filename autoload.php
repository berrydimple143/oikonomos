<?php 
	spl_autoload_register(function($class) {
		$prefix = "App\\";
		$dir = __DIR__ . "/src/";

		$len = strlen($prefix);	

		if(strncmp($prefix, $class, $len) !== 0) {
			return;
		}

		$relative_class = substr($class, $len);

		$file = $dir . str_replace("\\", "/", $relative_class) . ".php";

		if(file_exists($file)) {
			require $file;
		}
	});

	use App\Core\Database;
	Database::connect();
	
?>