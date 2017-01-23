<?php 

include ("db_connect.inc.php");

$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$resultquerry = mysqli_query($dbc, "SELECT * FROM team_rating LIMIT 1");

$result = mysqli_fetch_row($resultquerry);

Print $result[0].", ".$result[1].", ".$result[2].", ".$result[3].", ".$result[4].", ".$result[5];


mysqli_close($dbc); 
?>
