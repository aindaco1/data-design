<?php
// first, require your class
require_once("awards.php");

// use constructor to create object
$awards = new Awards(null, 1, 1967, "Billboard Top 200");

// connect to mySQL and populate the database

try {
// tell mysqli to throw exceptions
	mysqli_report(MYSQLI_REPORT_STRICT);

// connect
	$mysqli = new mysqli("localhost", "aindacochea", "learflaresnpairbob", "aindacochea");

// insert into mySQL
	$awards->insert($mysqli);

// disconnect from mySQL
	$mysqli->close();

// var_dump the result to affirm we have a real primary key
	var_dump($awards);
}
catch(Exception $exception) {
	//
	echo "Exception: " . $exception->getMessage() . "<br />";
	echo $exception->getFile() . ":" . $exception->getLine();
}
?>