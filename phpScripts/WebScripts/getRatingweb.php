<?php

include ("../BasicScripts/db_connect.inc.php");
include ("../BasicScripts/getRating.php");

include ("../WebScripts/themeload.html");


$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$OrderBy = mysqli_real_escape_string($dbc, $_GET['OrderBy']);

$result = getRating($dbc, $OrderBy);

$values=$result[0];

$tablehead="<tr> <td>Platz</td> <td>Name</td> <td><a href=\"getRatingweb.php?OrderBy=Front\">Sturm</a></td> <td><a href=\"getRatingweb.php?OrderBy=Back\">Verteidigung</a></td> <td><a href=\"getRatingweb.php\">Gesamt</a></td> </tr>";

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

	include ("../WebScripts/bodytest.html");

?>