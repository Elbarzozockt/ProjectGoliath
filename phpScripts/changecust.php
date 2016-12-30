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



$checkquery = "SELECT * FROM player WHERE (name= '$name') AND (password='$password')";
if(mysqli_num_rows(mysqli_query($dbc, $checkquery)) >= 1)
{
	
$query = "UPDATE player SET picture='$picture' WHERE (name='$name') AND (password='$password')";
$result = mysqli_query($dbc, $query) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 
//Account geändert
print "Account wurde geändert!";

}
else
{
	
//account nicht vorhanden oder passwort stimmt nicht	
print "Accountname oder Passwort falsch!";

}


mysqli_close($dbc); 

?>
