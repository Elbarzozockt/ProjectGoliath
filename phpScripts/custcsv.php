<?php

include ("./db_connect.inc.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

// $dbs = mysqli_select_db($dbc, DBNAME);
// if (!$dbs) {
    // die("Database selection failed: " . mysqli_error($dbc));
    // exit(); 
// }

$result = mysqli_query($dbc, "SHOW COLUMNS FROM player");
$numberOfRows = mysqli_num_rows($result);
if ($numberOfRows > 0) {

$values = mysqli_query($dbc, "SELECT name FROM player");

while ($rowr = mysqli_fetch_row($values)) {
 for ($j=0;$j<$numberofrows;$j++) {
  $csv_output .= $rowr[$j].", ";
 }
 $csv_output .= "\n";
}

//$csv_output=mysql_fetch_array($values);

}

print $csv_output;
exit;
?>
