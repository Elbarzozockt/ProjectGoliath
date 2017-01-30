<?php

 function getTeamrating($dbc){
	 
	 $numberOfRows = 4;//IdTeam, IdTeamConfig, //mintr.IDT2, mintr.TC2, 
	 
	if ($numberOfRows > 0) {
		$values = mysqli_query($dbc, "SELECT ts.name, mintr.trueskill, IF(mintr.TC2='1', tname2.minpl, tname.maxpl) AS pFront, IF(mintr.TC2='2', tname2.minpl, tname.maxpl) AS pBack
										FROM(SELECT tr.Id_team, tr.Id_team_config, MAX(km.timestamp) as MaxTime
												FROM team_rating AS tr
												INNER JOIN kicker_matches AS km ON km.Id=tr.Id_match
												GROUP BY Id_team, Id_team_config) AS maxtr
										INNER JOIN(       
												SELECT tr2.Id_team AS IDT2, tr2.Id_team_config AS TC2, tr2.trueskill, km2.timestamp AS timetes
												FROM team_rating AS tr2
												INNER JOIN kicker_matches AS km2 ON km2.Id=tr2.Id_match
												) AS mintr ON (mintr.timetes=maxtr.MaxTime AND mintr.IDT2=maxtr.Id_team AND mintr.TC2=maxtr.Id_team_config)
										INNER JOIN(
												SELECT tm3.Id_team AS IDT3, pl3.name AS maxpl
												FROM player AS pl3
												INNER JOIN (SELECT Id_team, MAX(Id_player) AS maxplayer FROM team_member GROUP BY Id_team ) AS tm3 ON tm3.maxplayer=pl3.Id
												GROUP BY IDT3
												) AS tname ON tname.IDT3=mintr.IDT2
										INNER JOIN(
												SELECT tm4.Id_team AS IDT4, pl4.name AS minpl
												FROM player AS pl4
												INNER JOIN (SELECT Id_team, MIN(Id_player) AS minplayer FROM team_member GROUP BY Id_team ) AS tm4 ON tm4.minplayer=pl4.Id
												GROUP BY IDT4
												) AS tname2 ON tname2.IDT4=mintr.IDT2
										INNER JOIN teams AS ts ON ts.Id=mintr.IDT2 
										GROUP BY mintr.IDT2, mintr.TC2
										ORDER BY mintr.trueskill DESC");
	}
	 
return array($values, $numberOfRows);
}

?>