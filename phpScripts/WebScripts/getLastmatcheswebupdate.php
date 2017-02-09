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

$numberOfFields=$result[1];
	for ($i=0;$i<sizeof($values);$i++) {
		$FlexBox.="	<div class=\"flex-item\">
						<div style=\"text-align:center;width:300px; height:auto;\">".$values[$i][1]."</div>
						</div>
					<div class=\"flex-item\">
					<div class=\"flex-container\" style=\"width:300px; height:auto;\">";
		
		
		for ($j=1;$j<$numberOfFields;$j++) {
			if($j==2 Or $j==5 Or $j==8 Or $j==11){ //Spieler Bilder & Score
				$FlexBox.="<div class=\"flex-item\" style=\"margin:auto;\">
							<div class=\"playerpic\">
								<img src=\"../Resources/pictures/".$values[$i][$j+1]." alt=\"".$values[$i][$j]."\" style=\"background-color: white;\" >
								<span>".$values[$i][$j+2]."</span>
							</div>
						</div>";
			}
			elseif($j==7) { //Ergebnis
				$FlexBox.="<div class=\"flex-item\" style=\"margin:auto;\">
								<div style=\"background-color:red;width:50px;height:50px;border-radius:25px;text-align:center;\">".($values[$i][3]+$values[$i][5]).":".($values[$i][7]+$values[$i][9])."</div>
				</div>";
			}
		}
		$FlexBox.="</div>
				</div>";
	}

	include ("../WebScripts/bodyLastmatchesupdate.html");

?>