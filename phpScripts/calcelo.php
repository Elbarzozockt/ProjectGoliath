<?php 

include ("db_connect.inc.php");
//include ("elo_fctn_simple.php");
include ("trueskill_fctn_graph.php");

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

$RanksScore = array(1, 2);

$Testplayer = array(
	array(1, 1000, 30),
	array(2, 1300, 25),
	array(3, 1200, 30),
	array(4, 1100, 30)
);

$test = calculate_trueskill_2vs2($Testplayer, $RanksScore);

// echo "moin";

echo $test[0][0];
echo ", ";
echo $test[0][1];
echo ", ";
echo $test[0][2];
echo ", ";
echo $test[1][0];
echo ", ";
echo $test[1][1];
echo ", ";
echo $test[1][2];
echo ", ";
echo $test[2][0];
echo ", ";
echo $test[2][1];
echo ", ";
echo $test[2][2];
echo ", ";
echo $test[3][0];
echo ", ";
echo $test[3][1];
echo ", ";
echo $test[3][2];
echo ", ";



mysqli_close($dbc); 
?>
