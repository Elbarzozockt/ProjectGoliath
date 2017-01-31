<?php

 function getTeam($dbc, $teamname){
	 
$numberOfRows = 9;
if ($numberOfRows > 0) {

$values = mysqli_query($dbc, "SELECT name, 
									coalesce((SELECT team_rating.trueskill 
												FROM team_rating 
													WHERE (team_rating.Id_team_config='1') AND team_rating.Id_team=teams.Id 
														ORDER BY team_rating.Id DESC 
															LIMIT 1), 1200) 
																AS TSFront, 
									coalesce((SELECT team_rating.trueskill 
												FROM team_rating 
													WHERE (team_rating.Id_team_config='2') AND team_rating.Id_team=teams.Id 
														ORDER BY team_rating.Id DESC 
															LIMIT 1), 1200) 
																AS TSBack, 
									(SELECT COUNT(team_rating.Id_team) 
												FROM team_rating 
													WHERE (team_rating.Id_team_config='1') AND team_rating.Id_team=teams.Id) 
														AS GamesFront, 
									(SELECT COUNT(team_rating.Id_team) 
												FROM team_rating  
													WHERE (team_rating.Id_team_config='2') AND team_rating.Id_team=teams.Id) 
													AS GamesBack,
									(SELECT player.name FROM player WHERE player.ID IN(SELECT MIN(Id_player)
												FROM team_member
												INNER JOIN player ON team_member.Id_player=player.Id
												INNER JOIN teams ON team_member.Id_team=teams.Id WHERE teams.name='$teamname')) AS teamplayer1,
									(SELECT player.name FROM player WHERE player.ID IN(SELECT MAX(Id_player)
												FROM team_member
												INNER JOIN player ON team_member.Id_player=player.Id
												INNER JOIN teams ON team_member.Id_team=teams.Id WHERE teams.name='$teamname')) AS teamplayer2,
									(SELECT player.picture FROM player WHERE player.ID IN(SELECT MIN(Id_player)
												FROM team_member
												INNER JOIN player ON team_member.Id_player=player.Id
												INNER JOIN teams ON team_member.Id_team=teams.Id WHERE teams.name='$teamname')) AS pictureplayer1,
									(SELECT player.picture FROM player WHERE player.ID IN(SELECT MAX(Id_player)
												FROM team_member
												INNER JOIN player ON team_member.Id_player=player.Id
												INNER JOIN teams ON team_member.Id_team=teams.Id WHERE teams.name='$teamname')) AS pictureplayer2
								FROM teams 
									WHERE teams.name='$teamname'");

}
return array($values, $numberOfRows);
}

// ,
									// (SELECT COUNT(Result) FROM (SELECT SUM(score) AS Result From player_scores
										// WHERE (((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											// WHERE (name='$accname' AND position='1'))) AND  (position='1' OR position='2')) OR ((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											// WHERE (name='$accname' AND position='3'))) AND  (position='3' OR position='4')))
										// GROUP BY Id_match
										// Having SUM(score) ='6') AS WINFRONTLIST) AS WINFRONT,
									// (SELECT COUNT(Result) FROM (SELECT SUM(score) AS Result From player_scores
										// WHERE (((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											// WHERE (name='$accname' AND position='2'))) AND  (position='1' OR position='2')) OR ((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											// WHERE (name='$accname' AND position='4'))) AND  (position='3' OR position='4')))
										// GROUP BY Id_match
										// Having SUM(score) ='6') AS WINBACKLIST) AS WINBACK	



?>