<?php

include ("./db_connect.inc.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$Id_league=1;

$GetIdlastfivematches_querry ="SELECT Id, timestamp FROM kicker_matches WHERE Id_league='$Id_league' ORDER BY Id DESC LIMIT 5";

$GetIdlastfivematches = mysqli_query($dbc, $GetIdlastfivematches_querry);

$Id_matches = array();
while ($row = mysqli_fetch_row($GetIdlastfivematches)) {
  $Id_matches[] = $row;
}

$numberOfRows = mysqli_num_rows($GetIdlastfivematches);

$player = array();

for($i=0; $i<$numberOfRows; $i++){
$k = $Id_matches[$i][0];
$iplus1= $i + 1;
$player_querry ="SELECT player.name, player_scores.score FROM player_scores INNER JOIN player ON player.Id=player_scores.Id_player WHERE (Id_match='$k') ORDER BY position";

$test =mysqli_query($dbc, $player_querry);

while ($row = mysqli_fetch_row($test)) {
  $player[$i][] = $row;
}

}

$csv_output=$Id_matches[3];

if ($numberOfRows > 0) {
	for ($i=0; $i<$numberOfRows; $i++){
		for ($j=0; $j<2;$j++){
			$csv_output.= $Id_matches[$i][$j].", ";
		}
		for ($k=0; $k<4;$k++) {
			$csv_output.= $player[$i][$k][0].", ";
		}
		$csv_output .= ($player[$i][0][1]+$player[$i][1][1]).":".($player[$i][2][1]+$player[$i][3][1]).", ";
		
		$csv_output .= "\n";
}
}

print $csv_output;

exit;
?>