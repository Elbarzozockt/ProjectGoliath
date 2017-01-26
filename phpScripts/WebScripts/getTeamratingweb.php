<?php

include ("../BasicScripts/db_connect.inc.php");
include ("../BasicScripts/getTeamrating.php");

include ("../WebScripts/header.html");


$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$result = getTeamrating($dbc);

$values=$result[0];

$numberOfRows=$result[1];

$tablehead="<tr> <td>Platz</td><td>Teamname</td><td>Trueskill</td> <td>Player Front</td> <td>Player Back</td></tr>";

$tablebody="";

$numberOfRows=$result[1];
$Rank=1;
	while ($rowr = mysqli_fetch_row($values)) {
		$tablebody .= "<tr> <td>".$Rank."</td>";
		$Rank++;
		for ($j=0;$j<$numberOfRows;$j++) {
			if($j==2 OR $j==3){
				$tablebody .= "<td><player>".$rowr[$j]."</player></td>";
			}else{
			$tablebody .= "<td>".$rowr[$j]."</td>";
			}
		}
		$tablebody .= "</tr>";
	}

	include ("../WebScripts/bodyRatingtable.html");

?>