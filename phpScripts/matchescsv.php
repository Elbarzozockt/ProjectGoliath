<?php

include ("./db_connect.inc.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$numberOfRows = 1;
if ($numberOfRows > 0) {
$values = mysqli_query($dbc, "SELECT Id FROM kicker_matches");
while ($rowr = mysqli_fetch_row($values)) {
 for ($j=0;$j<$numberOfRows;$j++) {
  $csv_output .= $rowr[$j];
 }
 $csv_output .= "\n";
}
}





//$csv_output = substr($csv_output, 0, -2);

print $csv_output;
exit;
?>