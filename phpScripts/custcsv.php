<?php

include ("./db_connect.inc.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

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

//$result = mysqli_query($dbc, "SHOW COLUMNS FROM player");
$numberOfRows = 4;
if ($numberOfRows > 0) {

$values = mysqli_query($dbc, "SELECT name, picture, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack FROM player");
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