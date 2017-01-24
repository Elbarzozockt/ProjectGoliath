<?php

 function getLastratings($dbc, $accname){
	 
	$LastMAXHundretRatingsF= mysqli_query($dbc, "SELECT trueskill From player_scores INNER JOIN player ON player.Id=player_scores.Id_player INNER JOIN kicker_matches ON kicker_matches.Id=player_scores.Id_match  WHERE (name='$accname' AND (position='1' OR position='3')) ORDER BY timestamp DESC 
			LIMIT 100");
			
	$numberOfRowsF = mysqli_num_rows($LastMAXHundretRatingsF);
	
	$LastMAXHundretRatingsB= mysqli_query($dbc, "SELECT trueskill From player_scores INNER JOIN player ON player.Id=player_scores.Id_player INNER JOIN kicker_matches ON kicker_matches.Id=player_scores.Id_match  WHERE (name='$accname' AND (position='2' OR position='4')) ORDER BY timestamp DESC 
			LIMIT 100");
	$numberOfRowsB = mysqli_num_rows($LastMAXHundretRatingsB);
	 
return array($LastMAXHundretRatingsF, $numberOfRowsF, $LastMAXHundretRatingsB, $numberOfRowsB);
}

?>