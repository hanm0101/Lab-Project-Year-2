<?php
require_once( 'initialise.php' );

function getMembers($tournamentID){
$membersOfTournament = find_members_of_tournament_by_row($tournamentID);
$i = 0;
if(mysqli_num_rows($membersOfTournament)>0){
while ($value = mysqli_fetch_assoc($membersOfTournament)){
    $members[$i]= $value['member_id'];
    $i++;
}
}
mysqli_free_result($membersOfTournament);
return $members;
}

function makeRoundRobin($tournamentID,array $getMembersArray){

    for($i=0; $i<count($getMembersArray); $i++){
        for($j = $i+1; $j<count($getMembersArray); $j++){
            makeMatch($getMembersArray[$i],$getMembersArray[$j],$tournamentID);
        }
    }
}
function makeMatch($player1ID, $player2ID,$tournamentID){
    $insert['tournament_id']=$tournamentID;
    $insert['member1_id']=$player1ID;
    $insert['member2_id']=$player2ID;
    $insert['outcome']=null;
    insert_match($insert);
}
function initialGroupTable($tournamentID){
    $members = getMembers($tournamentID);
    for($i=0; $i<count($members); $i++){
        $group[$members[$i]]['member_id']=$members[$i];
        $group[$members[$i]]['Elo']= find_members_elo($members[$i]);
        $group[$members[$i]]['Score']=0;
    }

    return $group;
}
function groupStageFinished($tournamentID){
$groupTable = initialGroupTable($tournamentID);
$matches = getTournamentMatches($tournamentID);
if(mysqli_num_rows($matches)>0){
    while ($value = mysqli_fetch_assoc($matches)){
        if($value['outcome']==1){
            $groupTable[$value['member1_id']]['Score']+=3;
        }
        if($value['outcome']==2){
            $groupTable[$value['member2_id']]['Score']+=3;
        }
        if($value['outcome']==3){
            $groupTable[$value['member1_id']]['Score']+=1;
            $groupTable[$value['member2_id']]['Score']+=1;

        }
    }
}
usort($groupTable,"sortPlayers");
$groupTable=array_reverse($groupTable);
$playersThatGoThrough = array_slice($groupTable,0,2);
makeFinal($playersThatGoThrough[0]['member_id'],$playersThatGoThrough[1]['member_id'],$tournamentID);
}
function sortPlayers($player1,$player2){
$score1 = $player1['Score'];
$score2 = $player2['Score'];
if($score1<$score2){
  return -1;
}
if($score1>$score2){
    return 1;
}
if($player1['Elo']<$player2['Elo']){
    return -1;
}
if($player1['Elo']>$player2['Elo']){
    return 1;
}
return 0;
}
function getTournamentMatches($tournamentID) {
    global $db;
    $sql = "SELECT * FROM Matches ";
    $sql .= "WHERE tournament_id='" . db_escape($db, $tournamentID) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function areAllMatchesUpdated($tournamentID){
    $matches = getTournamentMatches($tournamentID);
    if(mysqli_num_rows($matches)>0){
        while ($value = mysqli_fetch_assoc($matches)){
            if($value['outcome']==0){
                return false;
            }
        }
}
else return false;


return true;
}
function makeFinal($player1ID, $player2ID,$tournamentID){
    $insert['tournament_id']=$tournamentID;
    $insert['member1_id']=$player1ID;
    $insert['member2_id']=$player2ID;
    $insert['outcome']=0;
    insert_final($insert);
   
}
function finalWasMade($tournamentID){
    $matches=getTournamentMatches($tournamentID);
    while($value=mysqli_fetch_assoc($matches)){
        if($value['final']==1){
            return true;
        }
    }
    return false;
}
?>
