<?php

 function getLastmatches($dbc, $SinceTime , $LimitOfMatches){
	 
$Id_league=1;


$GetIdLastmatches_querry ="SELECT Id, timestamp FROM kicker_matches WHERE Id_league='$Id_league' ORDER BY Id DESC LIMIT ".$LimitOfMatches;

$GetIdLastmatches = mysqli_query($dbc, $GetIdLastmatches_querry);

$Id_matches = array();
while ($row = mysqli_fetch_row($GetIdLastmatches)) {
  $Id_matches[] = $row;
}

$values=$Id_matches;

$numberOfRows = mysqli_num_rows($GetIdLastmatches);

$player = array();

for($i=0; $i<$numberOfRows; $i++){
$k = $Id_matches[$i][0];
$iplus1= $i + 1;
$player_querry ="SELECT player.name, player.picture, player_scores.score FROM player_scores INNER JOIN player ON player.Id=player_scores.Id_player WHERE (Id_match='$k') ORDER BY position";

$test =mysqli_query($dbc, $player_querry);

while ($row = mysqli_fetch_row($test)) {
  $values[$i][] = $row[0];
  $values[$i][] = $row[1];
}

}

$numberOfFields=sizeof($values[0]);

return array($values, $numberOfFields);
}

?>