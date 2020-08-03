<?php

	require_once('db_credentials.php');

	function db_connect() {
		$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
		confirm_db_connect();
		static $create_db_called = false;
		if (!$create_db_called) {
			$create_db_called = true;
			create_db($connection);
		}
		return $connection;
	}

	function db_disconnect($connection) {
		if(isset($connection)) {
		  mysqli_close($connection);
		}
	}

	function db_escape($connection, $string) {
		return mysqli_real_escape_string($connection, $string);
	}

	function confirm_db_connect() {
		if(mysqli_connect_errno()) {
		  $msg = "Database connection failed: ";
		  $msg .= mysqli_connect_error();
		  $msg .= " (" . mysqli_connect_errno() . ")";
		  exit($msg);
		}
	}

	function confirm_result_set($result_set) {
		if (!$result_set) {
			exit("Database query failed.");
		}
	}

	function create_db($connection) {
		mysqli_query($connection, "CREATE DATABASE ".DB_NAME);


		mysqli_select_db($connection, DB_NAME);

		$templine = '';
		$lines = file(PROJECT_PATH . '\Database.sql');
		foreach($lines as $line) {
			if (substr($line, 0, 2) == '--' || $line == '') {
				continue;
			}
			$templine .= $line;
			if (substr(trim($line), -1, 1) == ';') {
				mysqli_query($connection, $templine);
				$templine = '';
			}
		}
	}

?>
