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



$player1 = mysqli_real_escape_string($dbc, $_GET['player1']);
$player2 = mysqli_real_escape_string($dbc, $_GET['player2']);
$player3 = mysqli_real_escape_string($dbc, $_GET['player3']);
$player4 = mysqli_real_escape_string($dbc, $_GET['player4']);
$score1 = mysqli_real_escape_string($dbc, $_GET['score1']);
$score2 = mysqli_real_escape_string($dbc, $_GET['score2']);
$score3 = mysqli_real_escape_string($dbc, $_GET['score3']);
$score4 = mysqli_real_escape_string($dbc, $_GET['score4']);

$player = array($player1, $player2, $player3, $player4);
$score	= array($score1, $score2, $score3, $score4);

$Id_league = 1;


//creation time stamp
$creation_time_stamp = date('Y-m-d H:i');

$querymatch = "INSERT INTO kicker_matches (Id_league, timestamp) VALUES ('$Id_league', '$creation_time_stamp')";

$resultmatch = mysqli_query($dbc, $querymatch) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 

//grade kreierte ID bekommen
$Id_match = mysqli_insert_id($dbc);

//$i =1;

//if schleife um jeden spieler in die player_scores einzutragen
for($i=1; $i<5; $i++)
{
$iminuseins=$i-1;
$Id_player_querry = "SELECT Id FROM player WHERE name='$player[$iminuseins]'";
$Id_player_abfrage = mysqli_query($dbc, $Id_player_querry) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
$Id_player =mysqli_fetch_array($Id_player_abfrage);
$queryscores = "INSERT INTO player_scores (Id_league, Id_match, Id_player, position, score) VALUES ('$Id_league', '$Id_match', '$Id_player[0]', '$i', '$score[$iminuseins]')";
$resultscore = mysqli_query($dbc, $queryscores) or trigger_error("Query MySQL Error: " . mysqli_error($dbc)); 
}

//echo $Id_player[0];

mysqli_close($dbc); 
?>
