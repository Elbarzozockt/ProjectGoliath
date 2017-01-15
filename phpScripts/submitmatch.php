<?php 

include ("db_connect.inc.php");
include ("trueskill_fctn_graph.php");

date_default_timezone_set('Europe/Berlin');

$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$player1 = mysqli_real_escape_string($dbc, $_GET['player1']);
$player2 = mysqli_real_escape_string($dbc, $_GET['player2']);
$player3 = mysqli_real_escape_string($dbc, $_GET['player3']);
$player4 = mysqli_real_escape_string($dbc, $_GET['player4']);
$score1 = mysqli_real_escape_string($dbc, $_GET['score1']);
$score2 = mysqli_real_escape_string($dbc, $_GET['score2']);
$score3 = mysqli_real_escape_string($dbc, $_GET['score3']);
$score4 = mysqli_real_escape_string($dbc, $_GET['score4']);

$player = array($player1, $player2, $player3, $player4);
$score	= array($score1, $score2, $score3, $score4);

$Id_league = 1;

//Tore in Ranking umwandeln
if (($score1+$score2)>($score3+$score4)){

$RanksScore =array(1, 2);

}else{
	
$RanksScore =array(2, 1);
	
}


//creation time stamp
$creation_time_stamp = date('Y-m-d H:i');

//Spielerdaten aus DB suchen
$playerlist =array();
for($i=0; $i<4; $i++){
	if($i==0 OR $i==2){ //0 und 2 sind Stürmer 1 und 3 sind Verteidiger
	$playerquerry= "SELECT player.Id, player.name, player_scores.standard_deviation, player_scores.trueskill FROM player INNER JOIN player_scores ON player.Id = player_scores.Id_player WHERE name= '$player[$i]' AND (player_scores.position='1' OR player_scores.position='3') ORDER BY player_scores.Id DESC LIMIT 1";
	}else{
	$playerquerry= "SELECT player.Id, player.name, player_scores.standard_deviation, player_scores.trueskill FROM player INNER JOIN player_scores ON player.Id = player_scores.Id_player WHERE name= '$player[$i]' AND (player_scores.position='2' OR player_scores.position='4')ORDER BY player_scores.Id DESC LIMIT 1";
	}
	$player_result = mysqli_query($dbc, $playerquerry);
	if(mysqli_num_rows($player_result)==1){
		$playerlist[]=mysqli_fetch_row($player_result);
	}else{
		$noGamesPlayer= mysqli_query($dbc, "SELECT player.Id, player.name FROM player WHERE player.name ='$player[$i]'");
		$playerlist[]=mysqli_fetch_row($noGamesPlayer);
		//$Test =mysqli_fetch_row($noGamesPlayer);
		$playerlist[$i][]=50;
		$playerlist[$i][]=1200;
		//print $player[$i];
		//print $player_result;
	}
}

//print $playerlist[0][0];

//Nachschauen ob alle Spieler Registiert sind
$checkplayer_querry= "SELECT Id, name FROM player WHERE name IN('$player[0]', '$player[1]', '$player[2]', '$player[3]') ";
$checkplayer_result =mysqli_query($dbc, $checkplayer_querry);

$debu =4-mysqli_num_rows($checkplayer_result);
//Fals ja wird das Spiel gewertet
if(mysqli_num_rows($checkplayer_result) == 4)
{
	$querymatch = "INSERT INTO kicker_matches (Id_league, timestamp) VALUES ('$Id_league', '$creation_time_stamp')";
	$resultmatch = mysqli_query($dbc, $querymatch) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));    // ACHTUNG WIEDER EINFÜGEN!!!!!!


	//grade kreierte ID bekommen
	$Id_match = mysqli_insert_id($dbc);

	//Array für Trueskillberechnung aufstellen
	$playerlistForTrueskill = array(
		array($playerlist[0][0], $playerlist[0][3], $playerlist[0][2]),
		array($playerlist[1][0], $playerlist[1][3], $playerlist[1][2]),
		array($playerlist[2][0], $playerlist[2][3], $playerlist[2][2]),
		array($playerlist[3][0], $playerlist[3][3], $playerlist[3][2])
	);

	//Trueskill berechnen
	$result_player = calculate_trueskill_2vs2($playerlistForTrueskill, $RanksScore);

	//if schleife um neue Daten der Spieler in die player_scores einzutragen
	for($i=1; $i<5; $i++)
	{
		$iminuseins=$i-1;
		if ($result_player[$iminuseins][0]==$playerlist[$iminuseins][0]){
			$queryscores = "INSERT INTO player_scores (Id_league, Id_match, Id_player, position, score, standard_deviation, trueskill) VALUES ('$Id_league', '$Id_match', '".$result_player[$iminuseins][0]."', '$i', '$score[$iminuseins]', '".$result_player[$iminuseins][2]."', '".$result_player[$iminuseins][1]."')";
			$resultscore = mysqli_query($dbc, $queryscores) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
			// print $result_player[$iminuseins][2];
			// print ",";
			// print $result_player[$iminuseins][1];
			// print ",";
			// print $result_player[$iminuseins][0];
		}else{
			print "IDs stimmen nicht überein";
			// print $result_player[$iminuseins][0] ;
			// print ",";
			// print $playerlist[$iminuseins][0] ;
		}
	}
	print "Match wurde eingetragen";
}else{
	print $debu." Spieler nicht registriert! Spiel wurde nicht gewertet.";
}


mysqli_close($dbc);

//funktion zum Erstellen eines Teams falls nicht vorhanden
function createteam($playerOne, $playerTwo){
$teamname="Ludolfs";
$teamexistsquerry = "SELECT Id_team from team_member Inner Join player ON player.Id=team_member.Id_player WHERE player.name='$playerOne' OR player.name='$playerTwo' group by Id_team having count(*) >1";
$teamexistsresult =mysql_query($dbc, $teamexistsquerry);
If(mysqli_num_rows($teamexistsresult)<1){
	
	$createteamquery="INSERT INTO teams (name, Id_league) VALUES ('$teamname', '$Id_league')";
	$resultcreateteam = mysqli_query($dbc, $createteamquery) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
	$Id_new_team = mysqli_insert_id($dbc);
	

	$createteamquery="INSERT INTO team_member (Id_team, Id_player) SELECT '$Id_new_team', player.Id FROM player WHERE player.name='$playerOne')";
	$resultcreateteam = mysqli_query($dbc, $createteamquery) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
	
	$createteamquery="INSERT INTO team_member (Id_team, Id_player) SELECT '$Id_new_team', player.Id FROM player WHERE player.name='$playerTwo')";
	$resultcreateteam = mysqli_query($dbc, $createteamquery) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
}
}
 
?>
