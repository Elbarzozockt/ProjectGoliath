<?php

include ("../BasicScripts/db_connect.inc.php");
include ("../BasicScripts/getAccount.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$accname = mysqli_real_escape_string($dbc, $_GET['accname']);

$result = getAccount($dbc, $accname);

$values=$result[0];

$numberOfRows=$result[1];
	echo '<table>';
	while ($rowr = mysqli_fetch_row($values)) {
		echo '<tr>';
		for ($j=0;$j<$numberOfRows;$j++) {
			echo '<td>',$rowr[$j],'</td>';
		}
		echo '</tr>';
	}
	echo '<table>';


?>