<?php

include ("../BasicScripts/db_connect.inc.php");
include ("../BasicScripts/getAccount.php");
include ("../BasicScripts/getLastratings.php");

$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$accname = mysqli_real_escape_string($dbc, $_GET['accname']);

$result = getAccount($dbc, $accname);

$values=$result[0];

$numberOfRows=$result[1];

$rowr = mysqli_fetch_row($values);

$playername = $rowr[0];
$trueskillfront = $rowr[2];
$trueskillback = $rowr[3];
$gamesFront = $rowr[4];
$gamesBack = $rowr[5];
$winFront = $rowr[6];
$winBack = $rowr[7];



$result = getLastratings($dbc, $accname);

$LastMAXHundretRatings=$result[0];

$numberOfRows=$result[1];

$xDataFromPHPF ="[";
$yDataFromPHPF ="[";

if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$xDataFromPHPF .=($i+1).", ";
	$yDataFromPHPF .= $rowr[($numberOfRows-$i-1)][0].", ";
}
}else{
	$xDataFromPHPF .= "1, ";
	$yDataFromPHPF .= "1200, ";
}

$xDataFromPHPF = substr($xDataFromPHPF, 0, -2);
$xDataFromPHPF .="]";
$yDataFromPHPF = substr($yDataFromPHPF, 0, -2);
$yDataFromPHPF .="]";


$LastMAXHundretRatings=$result[2];

$numberOfRows=$result[3];

$xDataFromPHPB ="[";
$yDataFromPHPB ="[";

if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$xDataFromPHPB .=($i+1).", ";
	$yDataFromPHPB .= $rowr[($numberOfRows-$i-1)][0].", ";
}
}else{
	$xDataFromPHPB .= "1, ";
	$yDataFromPHPB .= "1200, ";
}

$xDataFromPHPB = substr($xDataFromPHPB, 0, -2);
$xDataFromPHPB .="]";
$yDataFromPHPB = substr($yDataFromPHPB, 0, -2);
$yDataFromPHPB .="]";


include ("../WebScripts/Test.html");

?>