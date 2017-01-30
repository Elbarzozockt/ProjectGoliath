<?php

include ("../BasicScripts/db_connect.inc.php");
//include ("../BasicScripts/getteam.php");

include ("../WebScripts/header.html");


$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$teamname = mysqli_real_escape_string($dbc, $_GET['teamname']);

$result = getteam($dbc, $teamname);

$values=$result[0];

$tablehead="<tr><td>Platz</td> <td>Name</td> <td><a href=\"getRatingweb.php?OrderBy=Front\">Sturm</a></td> <td><a href=\"getRatingweb.php?OrderBy=Back\">Verteidigung</a></td> <td><a href=\"getRatingweb.php\">Gesamt</a></td> </tr>";

$tablebody="";

$numberOfRows=$result[1];
$Rank=1;
	while ($rowr = mysqli_fetch_row($values)) {
		$tablebody .= "<tr> <td>".$Rank."</td>";
		$Rank++;
		for ($j=0;$j<$numberOfRows;$j++) {
			if($j==0){
				$tablebody .= "<td><player>".$rowr[$j]."</player></td>";
			}else{
			$tablebody .= "<td>".$rowr[$j]."</td>";
			}
		}
		$tablebody .= "</tr>";
	}

	include ("../WebScripts/body.html");

?>