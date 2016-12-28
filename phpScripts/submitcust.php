<?php 

include ("db_connect.inc.php");

date_default_timezone_set('Europe/Berlin');

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
$name = mysqli_real_escape_string($dbc, $_GET['name']);
$password = mysqli_real_escape_string($dbc,$_GET['password']);
$picture = mysqli_real_escape_string($dbc,$_GET['picture']);
//creation time stamp
$creation_time_stamp = date('Y-m-d');

$checkquery = "SELECT name FROM player WHERE name='$name'";

if(mysqli_num_rows(mysqli_query($dbc, $checkquery)) >= 1)
{
	print '0';
}
else
{
$query = "INSERT INTO player (name, password, picture, creation_time_stamp) VALUES ('$name', '$password', '$picture', '$creation_time_stamp')";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 
	
	print '1';
}

mysqli_close($dbc); 
?>
