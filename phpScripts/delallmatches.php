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
$Account = mysqli_real_escape_string($dbc, $_GET['Account']);
$password = mysqli_real_escape_string($dbc,$_GET['password']);
//$picture = mysqli_real_escape_string($dbc,$_GET['picture']);
//creation time stamp
//$creation_time_stamp = date('Y-m-d');

if ($Account == "Admin" & $password == "H3FT1G"){
$query = "DELETE FROM kicker_matches";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

$query = "DELETE FROM player_scores";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

//Match wurde gelöscht
print "Alle Matches wurden gelöscht!";
}
else
{
	print "Account oder Passwort falsch!";
}

mysqli_close($dbc); 
?>
