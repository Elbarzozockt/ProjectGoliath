<?php 

require './PHPSkills/vendor/autoload.php';

use Moserware\Skills\TrueSkill\FactorGraphTrueSkillCalculator;
use Moserware\Skills\TrueSkill\TwoPlayerTrueSkillCalculator;
use Moserware\Skills\GameInfo;
use Moserware\Skills\RatingContainer;
use Moserware\Skills\Player;
use Moserware\Skills\Team;
use Moserware\Skills\Rating;

function calculate_trueskill_2vs2($playerIdWithRatingWithDeviation, $Ranks){ 

$TrueskillCalc = new FactorGraphTrueSkillCalculator();

$gameinfo =new GameInfo();

$neuerRatingContainer =new RatingContainer();

$player1 = new Player($playerIdWithRatingWithDeviation[0][0]);
$player2 = new Player($playerIdWithRatingWithDeviation[1][0]);
$player3 = new Player($playerIdWithRatingWithDeviation[2][0]);
$player4 = new Player($playerIdWithRatingWithDeviation[3][0]);

$Rating1 = new Rating($playerIdWithRatingWithDeviation[0][1], $playerIdWithRatingWithDeviation[0][2]);
$Rating2 = new Rating($playerIdWithRatingWithDeviation[1][1], $playerIdWithRatingWithDeviation[1][2]);
$Rating3 = new Rating($playerIdWithRatingWithDeviation[2][1], $playerIdWithRatingWithDeviation[2][2]);
$Rating4 = new Rating($playerIdWithRatingWithDeviation[3][1], $playerIdWithRatingWithDeviation[3][2]);

$team1 = new Team();
$team1->addPlayer($player1, $Rating1);
$team1->addPlayer($player2, $Rating2);

$team2 = new Team();
$team2->addPlayer($player3, $Rating3);
$team2->addPlayer($player4, $Rating4);

$bothteams = array($team1, $team2);

$neuerRatingContainer=$TrueskillCalc->calculateNewRatings($gameinfo, $bothteams, $Ranks);

$NewRating1=$neuerRatingContainer->getRating($player1);
$NewRating2=$neuerRatingContainer->getRating($player2);
$NewRating3=$neuerRatingContainer->getRating($player3);
$NewRating4=$neuerRatingContainer->getRating($player4);

return array(
	array($player1->getId(), round($NewRating1->getMean()), round($NewRating1->getStandardDeviation(), 3)),
	array($player2->getId(), round($NewRating2->getMean()), round($NewRating2->getStandardDeviation(), 3)),
	array($player3->getId(), round($NewRating3->getMean()), round($NewRating3->getStandardDeviation(), 3)),
	array($player4->getId(), round($NewRating4->getMean()), round($NewRating4->getStandardDeviation(), 3))
	);
}

function calculate_trueskill_1vs1($teamIdWithRatingWithDeviation, $Ranks){ 

$TrueskillCalc = new FactorGraphTrueSkillCalculator();

$gameinfo =new GameInfo();

$neuerRatingContainer =new RatingContainer();

$player1 = new Player($teamIdWithRatingWithDeviation[0][0]);
$player2 = new Player($teamIdWithRatingWithDeviation[1][0]);

$Rating1 = new Rating($teamIdWithRatingWithDeviation[0][1], $teamIdWithRatingWithDeviation[0][2]);
$Rating2 = new Rating($teamIdWithRatingWithDeviation[1][1], $teamIdWithRatingWithDeviation[1][2]);

$team1 = new Team();
$team1->addPlayer($player1, $Rating1);

$team2 = new Team();
$team2->addPlayer($player2, $Rating2);

$bothteams = array($team1, $team2);

$neuerRatingContainer=$TrueskillCalc->calculateNewRatings($gameinfo, $bothteams, $Ranks);

$NewRating1=$neuerRatingContainer->getRating($player1);
$NewRating2=$neuerRatingContainer->getRating($player2);

return array(
	array($player1->getId(), round($NewRating1->getMean()), round($NewRating1->getStandardDeviation(), 3)),
	array($player2->getId(), round($NewRating2->getMean()), round($NewRating2->getStandardDeviation(), 3))
	);
}

?>
