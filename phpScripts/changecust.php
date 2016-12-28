<?php 

include ("db_connect.inc.php");


//mysqli_connect(host,username,password,dbname,port,socket);
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

$name = mysqli_real_escape_string($dbc, $_GET['name']);
$password = mysqli_real_escape_string($dbc,$_GET['password']);
$picture = mysqli_real_escape_string($dbc,$_GET['picture']);


$query = "UPDATE player SET picture='$picture' WHERE (name='$name') AND (password=$password)";

$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

mysqli_close($dbc); 

?>

<!-- http://newjustin.com/updatecust.php?FirstName=Sue&LastName=Banas&Street=123&City=Pittsburgh&State=PA&Zip=15222&Email=derek@aol.com&Phone=4125551212&CustomerId=14
-->
