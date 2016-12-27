<?php 

DEFINE ('DBUSER', 'ch_warn_read'); 
DEFINE ('DBPW', '51ONP71W9rRXiik2'); 
DEFINE ('DBHOST', '78.46.160.25');
DEFINE ('DBPORT', '3306'); 
DEFINE ('DBNAME', 'ch_warn_adm'); 

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

//player ID automatisch
$name = mysqli_real_escape_string($dbc, $_GET['name']);
$password = mysqli_real_escape_string($dbc,$_GET['password']);
//$picture = mysqli_real_escape_string($dbc,$_GET['picture']);
//creation time stamp
//$creation_time_stamp = date('Y-m-d');

$query = "DELETE FROM player WHERE (name= '$name') AND (password='$password')";

$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

mysqli_close($dbc); 
?>