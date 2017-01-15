<?php

include ("./db_connect.inc.php");
 
$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$accname = mysqli_real_escape_string($dbc, $_GET['accname']);
$Position = mysqli_real_escape_string($dbc, $_GET['position']);

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

$LastMAXHundretRatings= mysqli_query($dbc, "SELECT trueskill From player_scores INNER JOIN player ON player.Id=player_scores.Id_player INNER JOIN kicker_matches ON kicker_matches.Id=player_scores.Id_match  WHERE (name='$accname' AND (position='1' OR position='3')) ORDER BY timestamp DESC 
			LIMIT 100");
			
$numberOfRows = mysqli_num_rows($LastMAXHundretRatings);

if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$csv_output .= $rowr[$i][0].", ";
}
$csv_output = substr($csv_output, 0, -2);
$csv_output .= "\n";
}else{$csv_output .= "1200\n";
}

$LastMAXHundretRatings= mysqli_query($dbc, "SELECT trueskill From player_scores INNER JOIN player ON player.Id=player_scores.Id_player INNER JOIN kicker_matches ON kicker_matches.Id=player_scores.Id_match  WHERE (name='$accname' AND (position='2' OR position='4')) ORDER BY timestamp DESC 
			LIMIT 100");
$numberOfRows = mysqli_num_rows($LastMAXHundretRatings);
if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$csv_output .= $rowr[$i][0].", ";
}
$csv_output = substr($csv_output, 0, -2);
$csv_output .= "\n";
}else{$csv_output .= "1200\n";
}
			
$LastMAXHundretRatings= mysqli_query($dbc, "SELECT trueskill From player_scores INNER JOIN player ON player.Id=player_scores.Id_player INNER JOIN kicker_matches ON kicker_matches.Id=player_scores.Id_match  WHERE (name='$accname') ORDER BY timestamp DESC 
		LIMIT 100");
$numberOfRows = mysqli_num_rows($LastMAXHundretRatings);
if ($numberOfRows>0){
$rowr = mysqli_fetch_all($LastMAXHundretRatings);
for ($i=0;$i<$numberOfRows;$i++) {
	$csv_output .= $rowr[$i][0].", ";
}
}else{$csv_output .= "1200\n";
}
$csv_output = substr($csv_output, 0, -2);

//$numberOfRows = mysqli_num_fields($LastMAXHundretRatings);
// if ($numberOfRows > 0) {
// while ($rowr = mysqli_fetch_row($LastMAXHundretRatings)) {
 // for ($j=0;$j<$numberOfRows;$j++) {
  // $csv_output .= $rowr[$j].", ";
 // }
 // $csv_output = substr($csv_output, 0, -2);
 // $csv_output .= "\n";
// }
// $csv_output = substr($csv_output, 0, -1);

// }

//$csv_output = substr($csv_output, 0, -2);

print $csv_output;
exit;
?>