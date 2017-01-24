<?php

include ("./BasicScripts/db_connect.inc.php");
include ("./BasicScripts/getLastratings.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$accname = mysqli_real_escape_string($dbc, $_GET['accname']);

$result = getLastratings($dbc, $accname);

$LastMAXHundretRatings=$result[0];

$numberOfRows=$result[1];


if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$csv_output .= $rowr[$i][0].", ";
}
$csv_output = substr($csv_output, 0, -2);
$csv_output .= "\n";
}else{$csv_output .= "1200\n";
}

$LastMAXHundretRatings=$result[2];

$numberOfRows=$result[3];

if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$csv_output .= $rowr[$i][0].", ";
}
$csv_output = substr($csv_output, 0, -2);
$csv_output .= "\n";
}else{$csv_output .= "1200\n";
}
			
$csv_output = substr($csv_output, 0, -1);

print $csv_output;
exit;
?>