<?php

 function getRating($dbc, $OrderBy){
	 
$numberOfRows = 4;
if ($numberOfRows > 0) {
	if ($OrderBy=="Front"){
		$values = mysqli_query($dbc, "SELECT name, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack, (round((coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200)+coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200))/2)) AS TSTot FROM player ORDER By TSFront DESC");
	}elseif($OrderBy=="Back"){
		$values = mysqli_query($dbc, "SELECT name, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack, (round((coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200)+coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200))/2)) AS TSTot FROM player ORDER By TSBack DESC");
	}else{
		$values = mysqli_query($dbc, "SELECT name, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSFront, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS TSBack, (round((coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200)+coalesce((SELECT player_scores.trueskill FROM player_scores WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id ORDER BY player_scores.Id DESC LIMIT 1), 1200))/2)) AS TSTot FROM player ORDER By TSTot DESC");
	}
}
return array($values, $numberOfRows);
}

?>