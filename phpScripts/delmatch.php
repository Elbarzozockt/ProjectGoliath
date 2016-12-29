<?php 

include ("db_connect.inc.php");

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

//player ID automatisch
$Id_match = mysqli_real_escape_string($dbc, $_GET['Id_match']);
//$password = mysqli_real_escape_string($dbc,$_GET['password']);
//$picture = mysqli_real_escape_string($dbc,$_GET['picture']);
//creation time stamp
//$creation_time_stamp = date('Y-m-d');


$checkquery = "SELECT Id FROM kicker_matches WHERE (Id= '$Id_match')";
if(mysqli_num_rows(mysqli_query($dbc, $checkquery)) >= 1)
{
	
$query = "DELETE FROM kicker_matches WHERE (Id= '$Id_match')";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

$query = "DELETE FROM player_scores WHERE (Id_match= '$Id_match')";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

//Match wurde gelöscht
print "Match wurde gelöscht!";

}
else
{
	
//Match nicht vorhanden
print "Match nicht vorhanden!";

}

mysqli_close($dbc); 
?>
