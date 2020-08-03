<?php
require_once( 'initialise.php' );

  function is_post_request() {
      return $_SERVER['REQUEST_METHOD'] == 'POST';
  }
  function url_for($script_path) {
      if ($script_path[0] != '/') {
          $script_path = "/" . $script_path;
      }
      return WWW_ROOT . $script_path;
  }
  function redirect_to($location) {
      header("Location: " . $location);
      exit;
  }
  function h($string="") {
      return htmlspecialchars($string);
  }
?>

<?php

// elo formula from the lab assignment before reading week
function eloCalculator($player1Elo,$player2Elo,$outcome){
    //outcome is int size 1 in sql. 0=p1 won 1= p2 won 2 = draw
if($outcome==3){
    $wActualPlayer1 = 0.5;
    $wActualPlayer2=0.5;
}
else if($outcome==1){
    $wActualPlayer1 = 1;
    $wActualPlayer2=0;
}
else if ($outcome==2){
    $wActualPlayer1=0;
    $wActualPlayer2=1;
}

$differenceInElo = calculateWExpected(intval($player1Elo)-intval($player2Elo));
$pPlayer1= round(50*($wActualPlayer1-$differenceInElo),0) + $player1Elo;
$pPlayer2 = round(50*($wActualPlayer2-$differenceInElo),0) + $player2Elo;
return array($pPlayer1,$pPlayer2);
}
function calculateWExpected($differenceInElo){
    return (1/(pow(10,(-$differenceInElo/400))+1));
}
// This function should be called after the tournament has ended
function updateEloAfterTournamentEnd($tournamentID){
    $matches=getTournamentMatches($tournamentID); //get matches
    while($value = mysqli_fetch_assoc($matches)){
        $elos=  eloCalculator(find_members_elo($value['member1_id'])
        ,find_members_elo($value['member2_id']),$value['outcome']);
        updateElo($elos[0],$value['member1_id'],$elos[1],$value['member2_id'],$tournamentID);

    }
    
}




?>
