<?php

function calculate_elo($elo_A_old, $elo_B_old, $result){ //$result =0 wenn unentschieden; =1 wenn A gewonnen; =2 wenn A zu null gewonnen

$E_A=1/(1+10^(($elo_B_old-$elo_A_old)/400));

$E_B=1-$E_A;

if($result == 0){
	$S_A = 0.5;
	$S_B =$S_A;
	$k=10;
}
elseif ($result == 1){
	$S_A = 1;
	$S_B = 0;
	$k=10;
}
else {
	$S_A = 1;
	$S_B = 0;
	$k=15;
}

$delta_elo_A = $k * ($S_A - $E_A);

$delta_elo_B = $k * ($S_B - $E_B);

$elo_A_new=$elo_A_old + $delta_elo_A;

$elo_B_new=$elo_B_old + $delta_elo_B;

return array ($elo_A_new, $elo_B_new, $delta_elo_A, $delta_elo_B);

}
?>
