<?php
//funktion zum Erstellen eines Teams falls nicht vorhanden
function createteam($playerOne, $playerTwo, $dbc, $matchtime){
	$playernamesresult =mysqli_query($dbc, "SELECT name FROM player WHERE Id='$playerOne' OR Id='$playerTwo'");
	$playername=mysqli_fetch_all($playernamesresult);
	$teamname=substr($playername[0][0], 0, 3).substr($playername[1][0], 0, 3);
$Id_league=1;
$teamexistsquerry = "SELECT Id_team from team_member Inner Join player ON player.Id=team_member.Id_player WHERE player.Id='$playerOne' OR player.Id='$playerTwo' group by Id_team having count(*) >1";
$teamexistsresult =mysqli_query($dbc, $teamexistsquerry);
If(mysqli_num_rows($teamexistsresult)<1){
	//Print  $matchtime;
	$createteamquery="INSERT INTO teams (name, Id_league, creation_time_stamp) VALUES ('$teamname', '$Id_league', '$matchtime')";
	$resultcreateteam = mysqli_query($dbc, $createteamquery) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
	$Id_new_team = mysqli_insert_id($dbc);
	$Id_team = $Id_new_team;
	

	$createteamquery="INSERT INTO team_member (Id_team, join_time_stamp, Id_player) SELECT '$Id_new_team','$matchtime' , player.Id FROM player WHERE player.Id='$playerOne'";
	$resultcreateteam = mysqli_query($dbc, $createteamquery) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
	
	$createteamquery="INSERT INTO team_member (Id_team, join_time_stamp, Id_player) SELECT '$Id_new_team','$matchtime' , player.Id FROM player WHERE player.Id='$playerTwo'";
	$resultcreateteam = mysqli_query($dbc, $createteamquery) or trigger_error("Query MySQL Error: " . mysqli_error($dbc));
}else{
	$resultID=mysqli_fetch_row($teamexistsresult);
	$Id_team=$resultID[0];
}

return($Id_team);

}
?>