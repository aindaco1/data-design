<?php
// first, require your class
require_once("credits.php");

// use constructor to create object
$credits = new Credits(null, 1, 1, "Arranger, Primary Artist");

// connect to mySQL and populate the database

try {
// tell mysqli to throw exceptions
	mysqli_report(MYSQLI_REPORT_STRICT);

// connect
	$mysqli = new mysqli("localhost", "aindacochea", "learflaresnpairbob", "aindacochea");

// insert into mySQL
	$credits->insert($mysqli);

// disconnect from mySQL
	$mysqli->close();

// var_dump the result to affirm we have a real primary key
	var_dump($credits);
}
catch(Exception $exception) {
	//
	echo "Exception: " . $exception->getMessage() . "<br />";
	echo $exception->getFile() . ":" . $exception->getLine();
}
?>