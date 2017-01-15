<?php

include ("./db_connect.inc.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$OrderBy = mysqli_real_escape_string($dbc, $_GET['OrderBy']);

//$numberOfRows = 1;
// if ($numberOfRows > 0) {
// $values = mysqli_query($dbc, "SELECT name FROM player");
// while ($rowr = mysqli_fetch_row($values)) {
 // for ($j=0;$j<$numberOfRows;$j++) {
  // $csv_output .= $rowr[$j];
 // }
 // $csv_output .= "\n";
// }
// }
$csv_output .= "name, Sturm, Verteidigung, Gesamt \n";
//$result = mysqli_query($dbc, "SHOW COLUMNS FROM player");
$numberOfRows = 4;
if ($numberOfRows > 0) {
	if ($OrderBy=="Front"){
		$values = mysqli_query($dbc, "SELECT name, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack, (round((coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200)+coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200))/2)) AS TSTot FROM player ORDER By TSFront DESC");
	}elseif($OrderBy=="Back"){
		$values = mysqli_query($dbc, "SELECT name, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack, (round((coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200)+coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200))/2)) AS TSTot FROM player ORDER By TSBack DESC");
	}else{
		$values = mysqli_query($dbc, "SELECT name, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack, (round((coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200)+coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200))/2)) AS TSTot FROM player ORDER By TSTot DESC");
	}
while ($rowr = mysqli_fetch_row($values)) {
 for ($j=0;$j<$numberOfRows;$j++) {
  $csv_output .= $rowr[$j].", ";
 }
 $csv_output = substr($csv_output, 0, -2);
 $csv_output .= "\n";
}
$csv_output = substr($csv_output, 0, -1);

}

//$csv_output = substr($csv_output, 0, -2);

print $csv_output;
exit;
?>