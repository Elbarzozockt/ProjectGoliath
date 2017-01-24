<?php

include ("./BasicScripts/db_connect.inc.php");
include ("./BasicScripts/getTeamrating.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}



$result = getTeamrating($dbc);

$values=$result[0];

$numberOfRows=$result[1];

$csv_output .= "trueskill, PlayerFront, PlayerBack \n";

while ($rowr = mysqli_fetch_row($values)) {
 for ($j=0;$j<$numberOfRows;$j++) {
  $csv_output .= $rowr[$j].", ";
 }
 $csv_output = substr($csv_output, 0, -2);
 $csv_output .= "\n";
}
$csv_output = substr($csv_output, 0, -1);


print $csv_output;
exit;
?>