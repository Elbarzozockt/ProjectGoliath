<?php

 function getLastratings($dbc, $teamname){
	 			
	$LastMAXHundretRatings_c1= mysqli_query($dbc, "SELECT trueskill From team_rating AS TR INNER JOIN teams AS T ON T.Id=TR.Id_team INNER JOIN kicker_matches AS KM ON KM.Id=TR.Id_match  WHERE (T.name='$teamname' AND (TR.Id_team_config='1')) ORDER BY timestamp DESC 
			LIMIT 100");
			
	$numberOfRows_c1 = mysqli_num_rows($LastMAXHundretRatings_c1);
	
	$LastMAXHundretRatings_c2= mysqli_query($dbc, "SELECT trueskill From team_rating AS TR INNER JOIN teams AS T ON T.Id=TR.Id_team INNER JOIN kicker_matches AS KM ON KM.Id=TR.Id_match  WHERE (T.name='$teamname' AND (TR.Id_team_config='2')) ORDER BY timestamp DESC 
			LIMIT 100");
			
	$numberOfRows_c2 = mysqli_num_rows($LastMAXHundretRatings_c2);
	 
return array($LastMAXHundretRatings_c1, $numberOfRows_c1, $LastMAXHundretRatings_c2, $numberOfRows_c2);
}

?>