<?php

include ("../BasicScripts/db_connect.inc.php");
include ("../BasicScripts/getLastmatches.php");

include ("../WebScripts/header.html");


$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$LimitOfMatches = mysqli_real_escape_string($dbc, $_GET['LimitOfMatches']);

$SinceTime = mysqli_real_escape_string($dbc, $_GET['SinceTime']);

$result = getLastmatches($dbc,$SinceTime ,$LimitOfMatches);

$values=$result[0];

$tablehead="<tr><td>Spiel</td><td>Zeit</td><td>Sturm</td><td>Tore</td><td>Verteidigung</td><td>Tore</td><td>Ergebnis</td> <td>Sturm</td><td>Tore</td><td>Verteidigung</td><td>Tore</td> </tr>";

$tablebody="";

$numberOfFields=$result[1];
	for ($i=0;$i<sizeof($values);$i++) {
		$tablebody .= "<tr>";
		for ($j=0;$j<$numberOfFields;$j++) {
			if($j==2 Or $j==4 Or $j==6 Or $j==8){
				$tablebody .= "<td><player>".$values[$i][$j]."</player></td>";
			}elseif($j==5) {
				$tablebody .= "<td>".$values[$i][$j]."</td><td>".($values[$i][3]+$values[$i][5]).":".($values[$i][7]+$values[$i][9])."</td>";
			}else{
			$tablebody .= "<td>".$values[$i][$j]."</td>";
			}
		}
		$tablebody .= "</tr>";
	}

	include ("../WebScripts/bodyLastmatches.html");

?>