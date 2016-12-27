<?php

include ("db_connect.inc.php");
 
$dbc = mysqli_connect(DBHOST,DBUSER,DBPW,DBNAME,DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

// $dbs = mysqli_select_db($dbc, DBNAME);
// if (!$dbs) {
    // die("Database selection failed: " . mysqli_error($dbc));
    // exit(); 
// }

// $result = mysqli_query($dbc, "SHOW COLUMNS FROM player");
// $numberOfRows = mysqli_num_rows($result);
// if ($numberOfRows > 0) {

/* By changing Fred below to another specific persons name you can limit access to just the part of the database for that individual. You could eliminate WHERE recorder_id='Fred' all together if you want to give full access to everyone. */

$values = mysqli_query($dbc, "SELECT name FROM player");

// while ($rowr = mysqli_fetch_row($values)) {
 // for ($j=0;$j<$numberOfRows;$j++) {
  // $csv_output .= $rowr[$j].", ";
 // }
 // $csv_output .= "\n";
// }

$csv_output=mysql_fetch_array($values);

}

print $csv_output;
exit;
?>
