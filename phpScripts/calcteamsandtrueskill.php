<?php 

include ("db_connect.inc.php");
include ("trueskill_fctn_graph.php");
include ("Createteam.php");

date_default_timezone_set('Europe/Berlin');

$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$Id_league = 1;

$GetLastId = mysqli_fetch_row(mysqli_query($dbc, "SELECT max(Id) FROM kicker_matches"));
//print $GetLastId[0];

//creation time stamp
$creation_time_stamp = date('Y-m-d H:i');

// $player=array();
	// $currentmatchquerry = mysqli_query($dbc, "SELECT player_scores.Id, Id_player AS testidplayer, position AS testposition, score AS testscore, (SELECT player_scores.standard_deviation FROM player_scores WHERE player_scores.Id_match < '26' AND IF (testposition=1 OR testposition =3, (player_scores.position='1' OR player_scores.position='3'), (player_scores.position='2' OR player_scores.position='4')) AND player_scores.Id_player=testidplayer ORDER BY player_scores.Id DESC LIMIT 1) AS Standarddev, (SELECT player_scores.trueskill FROM player_scores WHERE player_scores.Id_match < '26' AND IF (testposition=1 OR testposition =3, (player_scores.position='1' OR player_scores.position='3'), (player_scores.position='2' OR player_scores.position='4')) AND player_scores.Id_player=testidplayer ORDER BY player_scores.Id DESC LIMIT 1) AS testtrueskill FROM kicker_matches INNER JOIN player_scores ON kicker_matches.Id = player_scores.Id_match WHERE Id_match='26'");
		// for($i=0; $i<4; $i++){
			// $player[]=mysqli_fetch_row($currentmatchquerry);
		// }

//Id vom Match bekommen
for ($u=1; $u<($GetLastId[0]+1); $u++){
	//$currentmatchquerry=mysqli_query($dbc, "SELECT Id_player, position, score FROM kicker_matches INNER JOIN player_scores ON player.Id = player_scores.Id_player WHERE Id_match='$u'");
$currentmatchquerry = mysqli_query($dbc, "SELECT Id_player AS testidplayer, position AS testposition, score AS testscore, coalesce((SELECT player_scores.standard_deviation FROM player_scores WHERE player_scores.Id_match < '$u' AND IF (testposition=1 OR testposition =3, (player_scores.position='1' OR player_scores.position='3'), (player_scores.position='2' OR player_scores.position='4')) AND player_scores.Id_player=testidplayer ORDER BY player_scores.Id DESC LIMIT 1), 50) AS Standarddev, coalesce((SELECT player_scores.trueskill FROM player_scores WHERE player_scores.Id_match < '$u' AND IF (testposition=1 OR testposition =3, (player_scores.position='1' OR player_scores.position='3'), (player_scores.position='2' OR player_scores.position='4')) AND player_scores.Id_player=testidplayer ORDER BY player_scores.Id DESC LIMIT 1), 1200) AS testtrueskill, kicker_matches.timestamp FROM kicker_matches INNER JOIN player_scores ON kicker_matches.Id = player_scores.Id_match WHERE Id_match='$u' ORDER BY testposition");
	if(mysqli_num_rows($currentmatchquerry)==4){
		$player=array();
		for($i=0; $i<4; $i++){
			$player[]=mysqli_fetch_row($currentmatchquerry);
			//print $player[$i][4];
		}

		
		//Array für Trueskillberechnung aufstellen
		$playerlistForTrueskill = array(
			array($player[0][0], $player[0][4], $player[0][3]),
			array($player[1][0], $player[1][4], $player[1][3]),
			array($player[2][0], $player[2][4], $player[2][3]),
			array($player[3][0], $player[3][4], $player[3][3])
		);
		
		//Tore in Ranking umwandeln
		if (($player[0][2]+$player[1][2])>($player[2][2]+$player[3][2])){		
		$RanksScore =array(1, 2);		
		}else{		
		$RanksScore =array(2, 1);	
		}				
		$result_player = calculate_trueskill_2vs2($playerlistForTrueskill, $RanksScore);
		
			//if schleife um neue Daten der Spieler in die player_scores einzutragen
		for($i=1; $i<5; $i++){
			$iminuseins=$i-1;
			if ($result_player[$iminuseins][0]==$player[$iminuseins][0]){
				$queryscores = "UPDATE player_scores SET standard_deviation='".$result_player[$iminuseins][2]."', trueskill='".$result_player[$iminuseins][1]."' WHERE Id_league='$Id_league' AND Id_match='$u' AND Id_player='".$result_player[$iminuseins][0]."'";
				$resultscore = mysqli_query($dbc, $queryscores) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
				// print $result_player[$iminuseins][2];
				// print ",";
				// print $result_player[$iminuseins][1];
				// print ",";
				// print $result_player[$iminuseins][0];
				// print " NEXT: ";
			}else{
				print "IDs stimmen nicht überein";
				// print $result_player[$iminuseins][0] ;
				// print ",";
				// print $playerlist[$iminuseins][0] ;
			}
		}
		//PRINT $player[0][5];
		$Id_team1=createteam($player[0][0], $player[1][0], $dbc, $player[0][5]);
		$Id_team2=createteam($player[2][0], $player[3][0], $dbc, $player[0][5]);
		
		//PRINT $Id_team1;
		
		
		if($player[0][0]<$player[1][0]){
			$Id_team1_config=1;
		}else{
			$Id_team1_config=2;
		}
		
		if($player[2][0]<$player[3][0]){
			$Id_team2_config=1;
		}else{
			$Id_team2_config=2;
		}
		
		$teams= array(
			array($Id_team1, $Id_team1_config),
			array($Id_team2, $Id_team2_config)
			);
			
		$checkteamratingquerry = mysqli_query($dbc, "SELECT Id_team FROM team_rating WHERE ID_match='$u'");
		
		if(mysqli_num_rows($checkteamratingquerry)<2){
			for($k=0; $k<2; $k++){
			//PRINT $teams[$k][0];
			$CreatRatingInsertquerry="INSERT INTO team_rating (Id_match, Id_team, Id_team_config) VALUES('$u', '".$teams[$k][0]."', '".$teams[$k][1]."')";
			$CreatRatingInsert =mysqli_query($dbc, $CreatRatingInsertquerry);
			}
		}
		$getTeamvalues = "SELECT Id_team AS testIdteam, 
								Id_team_config AS testIdteamconfig,
								coalesce((SELECT team_rating.standard_deviation FROM team_rating 
											WHERE team_rating.Id_match < '$u' AND (Id_team_config=testIdteamconfig) AND team_rating.Id_team=testIdteam 
											ORDER BY team_rating.Id DESC LIMIT 1), 50) AS Standarddev,
								coalesce((SELECT team_rating.trueskill FROM team_rating 
											WHERE team_rating.Id_match < '$u' AND (Id_team_config=testIdteamconfig) AND team_rating.Id_team=testIdteam 
											ORDER BY team_rating.Id DESC LIMIT 1), 1200) AS TSteam
								FROM team_rating WHERE team_rating.Id_match='$u' ORDER BY team_rating.Id";
		$teamvaluesresult =mysqli_query($dbc, $getTeamvalues);
		
		$teamtemp=array();
		for($i=0; $i<2; $i++){
			$teamtemp[]=mysqli_fetch_row($teamvaluesresult);
			//print $player[$i][4];
		}
		
		$teamlistForTrueskill = array(
			array($teams[0][0], $teamtemp[0][3], $teamtemp[0][2]),
			array($teams[1][0], $teamtemp[1][3], $teamtemp[1][2])
		);
		
		$result_team=calculate_trueskill_1vs1($teamlistForTrueskill, $RanksScore);
		
		//if schleife um neue Daten der Teams in die team_rating einzutragen
		for($i=1; $i<3; $i++){
			$iminuseins=$i-1;
			if ($result_team[$iminuseins][0]==$teams[$iminuseins][0]){
				$queryscores = "UPDATE team_rating SET standard_deviation='".$result_team[$iminuseins][2]."', trueskill='".$result_team[$iminuseins][1]."' WHERE Id_match='$u' AND Id_team='".$result_team[$iminuseins][0]."'";
				$resultscore = mysqli_query($dbc, $queryscores) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
				// print $result_player[$iminuseins][2];
				// print ",";
				// print $result_player[$iminuseins][1];
				// print ",";
				// print $result_player[$iminuseins][0];
				// print " NEXT: ";
			}else{
				print "IDs stimmen nicht überein";
				// print $result_player[$iminuseins][0] ;
				// print ",";
				// print $playerlist[$iminuseins][0] ;
			}
		}
	}
}

?>
