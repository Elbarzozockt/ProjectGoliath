<?php

 function getAccount($dbc, $accname){
	 
$numberOfRows = 8;
if ($numberOfRows > 0) {

$values = mysqli_query($dbc, "SELECT name, 
									picture, 
									coalesce((SELECT player_scores.trueskill 
												FROM player_scores 
													WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id 
														ORDER BY player_scores.Id DESC 
															LIMIT 1), 1200) 
																AS TSFront, 
									coalesce((SELECT player_scores.trueskill 
												FROM player_scores 
													WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id 
														ORDER BY player_scores.Id DESC 
															LIMIT 1), 1200) 
																AS TSBack, 
									(SELECT COUNT(player_scores.Id_player) 
												FROM player_scores 
													WHERE (player_scores.position='1' OR player_scores.position='3') AND player_scores.Id_player=player.Id) 
														AS GamesFront, 
									(SELECT COUNT(player_scores.Id_player) 
												FROM player_scores 
													WHERE (player_scores.position='2' OR player_scores.position='4') AND player_scores.Id_player=player.Id) 
													AS GamesBack,
									(SELECT COUNT(Result) FROM (SELECT SUM(score) AS Result From player_scores
										WHERE (((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											WHERE (name='$accname' AND position='1'))) AND  (position='1' OR position='2')) OR ((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											WHERE (name='$accname' AND position='3'))) AND  (position='3' OR position='4')))
										GROUP BY Id_match
										Having SUM(score) ='6') AS WINFRONTLIST) AS WINFRONT,
									(SELECT COUNT(Result) FROM (SELECT SUM(score) AS Result From player_scores
										WHERE (((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											WHERE (name='$accname' AND position='2'))) AND  (position='1' OR position='2')) OR ((Id_match In(SELECT Id_match From player_scores INNER JOIN player ON player_scores.Id_player= player.Id 
											WHERE (name='$accname' AND position='4'))) AND  (position='3' OR position='4')))
										GROUP BY Id_match
										Having SUM(score) ='6') AS WINBACKLIST) AS WINBACK	
								FROM player 
									WHERE player.name='$accname'");

}
return array($values, $numberOfRows);
}

?>