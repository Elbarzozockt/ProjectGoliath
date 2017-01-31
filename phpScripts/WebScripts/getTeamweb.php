<?php

include ("../BasicScripts/db_connect.inc.php");
include ("../BasicScripts/getTeam.php");
include ("../BasicScripts/getLastTeamratings.php");

$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$teamname = mysqli_real_escape_string($dbc, $_GET['teamname']);

$result = getTeam($dbc, $teamname);

$values=$result[0];

$numberOfRows=$result[1];

$rowr = mysqli_fetch_row($values);

$teamname= $rowr[0];
$teammember1 = $rowr[5];
$teammember2 =$rowr[6];
$trueskill_c1 = $rowr[1];
$trueskill_c2 = $rowr[2];
$games_c1 = $rowr[3];
$games_c2 = $rowr[4];
$win_c1 = 0;
$win_c2 = 0;
$pictureplayer1 = $rowr[7];
$pictureplayer2 = $rowr[8];

$result = getLastTeamratings($dbc, $teamname);

$LastMAXHundretRatings=$result[0];

$numberOfRows=$result[1];

$xDataFromPHP_c1 ="[";
$yDataFromPHP_c1 ="[";

if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$xDataFromPHP_c1 .=($i+1).", ";
	$yDataFromPHP_c1 .= $rowr[($numberOfRows-$i-1)][0].", ";
}
}else{
	$xDataFromPHP_c1 .= "1, ";
	$yDataFromPHP_c1 .= "1200, ";
}

$xDataFromPHP_c1 = substr($xDataFromPHP_c1, 0, -2);
$xDataFromPHP_c1 .="]";
$yDataFromPHP_c1 = substr($yDataFromPHP_c1, 0, -2);
$yDataFromPHP_c1 .="]";


$LastMAXHundretRatings=$result[2];

$numberOfRows=$result[3];

$xDataFromPHP_c2 ="[";
$yDataFromPHP_c2 ="[";

if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$xDataFromPHP_c2 .=($i+1).", ";
	$yDataFromPHP_c2 .= $rowr[($numberOfRows-$i-1)][0].", ";
}
}else{
	$xDataFromPHP_c2 .= "1, ";
	$yDataFromPHP_c2 .= "1200, ";
}

$xDataFromPHP_c2 = substr($xDataFromPHP_c2, 0, -2);
$xDataFromPHP_c2 .="]";
$yDataFromPHP_c2 = substr($yDataFromPHP_c2, 0, -2);
$yDataFromPHP_c2 .="]";


include ("../WebScripts/teaminfo.html");

?>