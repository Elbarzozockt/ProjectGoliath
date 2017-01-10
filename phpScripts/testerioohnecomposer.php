<?php 

include ("db_connect.inc.php");

include ("/TrueskillScripts/Rating.php");
include ("/TrueskillScripts/Team.php");
include ("/TrueskillScripts/Player.php");
//include ("/TrueskillScripts/RatingContainer.php");
include ("/TrueskillScripts/GameInfo.php");
include ("/TrueskillScripts/TrueSkill/FactorGraphTrueSkillCalculator.php");

$dbc = mysqli_connect($DBHOST,$DBUSER,$DBPW,$DBNAME,$DBPORT);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

//$JO = new TwoPlayerTrueSkillCalculator();

$JO = new Moserware\Skills\TrueSkill\FactorGraphTrueSkillCalculator();

$Test =new Moserware\Skills\GameInfo();

$neuerRatingContainer =new Moserware\Skills\RatingContainer();

$player1 = new Player(1);
$player2 = new Player(2);
$Rating1 = new Rating(1200, 180);
$Rating2 = new Rating(1200, 200);

$player3 = new Player(3);
$player4 = new Player(4);
$Rating3 = new Rating(1200, 200);
$Rating4 = new Rating(1200, 200);



$team1 = new Team();
$team1->addPlayer($player1, $Rating1);
$team1->addPlayer($player2, $Rating2);

$team2 = new Team();
$team2->addPlayer($player3, $Rating3);
$team2->addPlayer($player4, $Rating4);


$bothteams = array($team1, $team2);
$Ranks = array(1, 2);


$neuerRatingContainer=$JO->calculateNewRatings($Test, $bothteams, $Ranks);


$newratingplayer1 = $neuerRatingContainer->getRating($player1);
$newratingplayer2 = $neuerRatingContainer->getRating($player2);
$newratingplayer3 = $neuerRatingContainer->getRating($player3);
$newratingplayer4 = $neuerRatingContainer->getRating($player4);

echo $newratingplayer1;
echo $newratingplayer2;
echo $newratingplayer3;
echo $newratingplayer4;

mysqli_close($dbc); 
?>
