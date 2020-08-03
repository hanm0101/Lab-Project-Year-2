<?php

	global $db;

	mysqli_query($db, "CREATE DATABASE ".DB_NAME);
	
	
	mysqli_select_db($db, DB_NAME);
	
	$templine = '';
	$lines = file('../../Database.sql');
	foreach($lines as $line) {
		if (substr($line, 0, 2) == '--' || $line == '') {
			continue;
		}
		$templine .= $line;
		if (substr(trim($line), -1, 1) == ';') {
			mysqli_query($db, $templine);
			$templine = '';
		}
	}

?>