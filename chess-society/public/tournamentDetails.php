<?php
session_start();
require_once( '../private/initialise.php' );
?>
 <?php
include(SHARED_PATH . '/memberheader.php');
?>



<html>
      <head>
           <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
           <meta charset="utf-8">
           <title>Members</title>
           <script src="jquery.js"></script>
           <script src="js/bootstrap.js"></script>
           <link href="css/bootstrap.css" rel="stylesheet" />
      </head>
      <body>
      <div class = "container">
         <form method = "post">
          <input type="submit" name="button" class="btn btn-secondary" value="Create Group Stage Matches">
          <input type="submit" name="button2" class="btn btn-secondary" value="Create Final after Group Stage Finished">
          <input type="submit" name="button3" class="btn btn-secondary" value= "End Tournament">
         </form>
         <?php

      if(isset($_POST['button']) ) {
         if( empty(find_matches_by_tournament($_GET['id']))){
           $players = getMembers($_GET['id']);
           if(count($players)>=2){
         makeRoundRobin($_GET['id'],$players);
           }
           else echo "Not enough members!";
         }
         else echo "Matches already made!";
      }
      if(isset($_POST['button2'])){
        if(!(empty(find_matches_by_tournament($_GET['id'])))){
          if(areAllMatchesUpdated($_GET['id'])){
            if(finalWasMade($_GET['id'])){
              echo "Final was already made!";
            }
            else{
           groupStageFinished($_GET['id']) ;
           echo "Final Made";
            }
          }
          else echo "Please update all match results first!";
        }
        else echo "No Group Stage matches made!";

      }
      if(isset($_POST['button3'])){
        if(!areAllMatchesUpdated($_GET['id'] )){
          echo "Can't end tournament yet. Wait until all matches are updated with results!";
        }
        else if(empty(find_matches_by_tournament($_GET['id']))){
          echo "No matches have happened!";
        }
        else if(!finalWasMade($_GET['id'])){
        echo "Final not made yet. Make a final match before ending tournament!";
        }
        
        else{
           if(isFinished($_GET['id'])){
            echo "Elo calculations already done for this tournament";
          }
          else{
            updateEloAfterTournamentEnd($_GET['id']);
            setFinished($_GET['id']);
            echo "Participants' Elo Updated";
          }
        }
      }
      if(isset($_POST['submitMatch'])){
        $outcome = explode(",",$_POST['result']);
        update_match_result($outcome[0],$outcome[1]);
        
      }
  ?>
      </div>

          <div class ="container w-75%" >
           <div class="table-responsive w-75%" style="margin-left:auto ; margin-right:auto;" >


                <?php
$curTournament = find_tournament_by_id( $_GET[ 'id' ] );
$curId         = $_GET[ 'id' ];
$dateError     = "";
$organiserError ="";
$title         = $curTournament[ 'title' ];
$desc          = $curTournament[ 'description' ];
$dead          = $curTournament[ 'deadline' ];
$date          = $curTournament[ 'tournament_date' ];

if ( isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ] == true && is_organiser($curId,$_SESSION['officer_id'])) {
				if ( isset( $_POST[ 'submit' ] ) ) {
								if ( $_POST[ 'deadline' ] > $_POST[ 'tournament_date' ] ) {
												$dateError .= "Deadline must come before date";
												$title = $_POST[ 'title' ];
												$desc  = $_POST[ 'description' ];
												$date  = $_POST[ 'tournament_date' ];
												$dead  = $_POST[ 'deadline' ];
								} //$_POST[ 'deadline' ] < $_POST[ 'tournament_date' ]
								else {
												$tour = array(
																 'title' => $_POST[ 'title' ],
																'id' => $_GET[ 'id' ],
																'description' => $_POST[ 'description' ],
																'tournament_date' => $_POST[ 'tournament_date' ],
																'deadline' => $_POST[ 'deadline' ]
												);
												update_tournament( $tour );
								}
				} //isset( $_POST[ 'submit' ] )
}else {
  $organiserError ="Only organisers  can update tournaments";
} //isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ] == true
echo "<table class=\"table table-striped table-hover\">";
echo <<< END_OF_TEXT

                                    <thead class="thead-light">
                                    <thead class="thead-dark  w-100">
                                     <th colspan="100">Tournament Details</th>

                                     </thead>
                                    <th> Title</th>
                                      <th>Description</th>
                                      <th>Deadline</th>
                                        <th>Date</th>
                                      <th></th>


                                           <tr style="w-50">


                                             <th colspan="100">
                                             <details>
                                             <summary>Tournament Info</summary>

                                             <table class="table">
                                             <thead>

                                             </thead>
                                             <tbody>

                                             <td >
                                             <div class="form-group ">
                                                <form action="" method="post">


                                               <input type="text" name="title" value="$title" required>

                                              </td>
                                              <td>


                                            <input type="text" name="description" value="$desc" required>
                                          <br>  <span class="overlay"> $organiserError</span> </br> </br>

                                               </td>
                                               <td>


                                                 <input type="date" name="deadline" value=$dead required>
                                                    <span class="overlay"> $dateError</span> </br> </br>
                                                 </td>
                                               <td>


                                                 <input type="date" name="tournament_date" value=$date required>


                                                </td>



                                                <td> <input type="submit" name ="submit" value="Edit Details"
                                />

                               </td></form>

                                                 </div>


                                             </tbody>
                                              </div>



                                           </table>
                                           </details>
                                         </th>


                                          </tr>
                                         </thead>

                                                                                   </div>


                                                                               </tbody>
                                                                                </div>



                                                                             </details>
                                                                           </th>


                                                                            </tr>
                                                                           </thead>




END_OF_TEXT;


if(isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ] == true && is_organiser($curId,$_SESSION['officer_id'])){
$organiser_url = url_for("organisers.php");
echo <<< END_OF_TEXT
                             <thead class="thead-light">
                                    <tr>

                                     <th colspan="100" style="text-align:center">
                                     <details>
                                     <summary><a href="$organiser_url?id=$curId">Manage Organisers</a></summary>
                                     </th>
END_OF_TEXT;
}
echo <<< END_OF_TEXT
                                    <thead class="thead-dark  w-100">
                                     <th colspan="100">Members</th>
                                     </thead>

END_OF_TEXT;
$no      = 1;
if(isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ] == true && is_organiser($curId,$_SESSION['officer_id'])){


echo "<th colspan=100>";
echo "<details>";
echo "<summary>Add members</summary>";
echo "<table class=\"table table-striped table-hover\">";
echo "<table class=\"table table-striped table-hover\">";
echo "<thead class=\"thead-dark\">";
echo "<tr>";
echo "<th>Name</th>" . "<th>LastName</th>" . "<th>Email</th><th></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

$members = find_all_members();

if ( mysqli_num_rows( $members ) > 0 ) {
				while ( $row = mysqli_fetch_assoc( $members ) ) {
								$second = $row[ 'id' ];
								$res    = $row[ 'email' ];
								$no     = $no + 1;
								if ( isset( $_POST[ 'button' . $no ] ) && !is_in_tournament( $second, $_GET[ 'id' ] ) ) {
												$newMem = array(
																 "member_id" => $second,
																"tournament_id" => $_GET[ 'id' ],
																"elo_before" => $row[ 'elo' ],
																"elo_after" => -1
												);
												insert_tournament_member( $newMem );
								} //isset( $_POST[ 'button' . $no ] ) && !is_in_tournament( $second, $_GET[ 'id' ] )
                if ( isset( $_POST[ 'button' . (-1)*$no ] ) && is_in_tournament( $second, $_GET[ 'id' ] ) ) {
												delete_member_from_tournament( $row[ 'id' ] );
								} //isset( $_POST[ 'button' . $no ] ) && is_in_tournament( $second, $_GET[ 'id' ] )

								if ( !is_in_tournament( $second, $_GET[ 'id' ] ) ) {
												echo "<tr>";
												echo "<td> " . h( $row[ 'fname' ] ) . " </td>";
												echo "<td> " . h( $row[ 'lname' ] ) . " </td>";
												echo "<td> <a href=\"" . url_for("profilepage.php") . "?email=$res    \"> " . h( $res ) . " </a> </td>";
												echo "<td>";
												echo "  <div class=\"container\"> <form action=\"\" method=\"post\">



                                                        <button type=\"submit\" id=\"prom\" name=\"button" . ( $no ) . "\" class=\"btn btn-primary\">ADD</div> </form>
                                                        ";
												echo "</td>";
								} //!is_in_tournament( $second, $_GET[ 'id' ] )
								echo "</tr";
								echo "</tr>";
				} //$row = mysqli_fetch_assoc( $members )
				echo "</tbody>";
				echo "</table>";
				echo "</th>";
} //mysqli_num_rows( $members ) > 0
echo <<< END_OF_TEXT



                                          </div>


                                      </tbody>
                                       </div>




                                    </details>
                                  </th>


                                   </tr>
                                  </thead>
END_OF_TEXT;
}

echo "<th colspan=100>";
echo "<details style=\"width=100%\">";
echo "<summary>See members</summary>";
echo "<table class=\"table table-striped table-hover\">";
echo "<table class=\"table table-striped table-hover\">";
echo "<thead class=\"thead-dark\">";
echo "<tr>";
echo "<th>Name</th>" . "<th>LastName</th>" . "<th>Email</th><th></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$no = 1;
$members = find_members_of_tournament_detailed( $_GET[ 'id' ] );
if ( mysqli_num_rows( $members ) > 0 ) {
				while ( $row = mysqli_fetch_assoc( $members ) ) {
								$second = $row[ 'id' ];
								$res    = $row[ 'email' ];
								$no     = $no + 1;
								if ( isset( $_POST[ 'button' . (-1)*$no ] ) && is_in_tournament( $second, $_GET[ 'id' ] ) ) {
												delete_member_from_tournament( $row[ 'id' ] );
								} //isset( $_POST[ 'button' . $no ] ) && is_in_tournament( $second, $_GET[ 'id' ] )
								if ( is_in_tournament( $second, $_GET[ 'id' ] ) ) {
												echo "<tr>";
												echo "<td> " . h( $row[ 'fname' ] ) . " </td>";
												echo "<td> " . h( $row[ 'lname' ] ) . " </td>";
												echo "<td> <a href=\"" . url_for("profilepage.php") . "?email=$res    \"> " . h( $res ) . " </a> </td>";
												echo "<td>";
												echo "  <div class=\"container\"> <form action=\"\" method=\"post\">



                                            <button type=\"submit\" id=\"prom\" name=\"button" . ((-1)* $no ) . "\" class=\"btn btn-primary\">REMOVE</div> </form>
                                            ";
												echo "</td>";
								} //is_in_tournament( $second, $_GET[ 'id' ] )
								echo "</tr";
								echo "</tr>";
  				}
        //$row = mysqli_fetch_assoc( $members )
        } //mysqli_num_rows( $members ) > 0
				echo "</tbody>";
				echo "</table>";
				echo "</th>";
				echo "<tr>";

				echo "<th colspan=100>";

        $matches_url = url_for("matches.php");
				echo <<< END_OF_TEXT
        <details style=\"width=100%\">
       <summary>View Matches</summary>


                                 

END_OF_TEXT;

?>
<table class="table table-striped table-hover">
<thead class="thead-dark">
<tr>
<th>Player 1</th><th>Player 2</th><th>Result</th><th>Tournament Stage</th> <th> Update Result</th>
</tr>
</thead>
<tbody>
<?php
$matches = getTournamentMatches($_GET['id']);
if(mysqli_num_rows($matches)>0){
  while($data = mysqli_fetch_assoc($matches)){
    $row = "<tr>"."<td>".get_full_name($data['member1_id'])."</td>"."<td>".get_full_name($data['member2_id'])."</td>";
    if($data['outcome']==0){
      $row .= "<td>"."TBD"."</td>";
    }
    else if($data['outcome']==1){
      $row .= "<td>".get_full_name($data['member1_id'])." Won"."</td>";
    }
    else if($data['outcome']==2){
      $row .= "<td>".get_full_name($data['member2_id'])." Won"."</td>";
    }
    else if($data['outcome']==3){
      $row .= "<td>"."Draw"."</td>";
    }
    if($data['final']==1){
      $row .= "<td>"."Final"."</td>";
    }
    else{
      $row .= "<td>"."Group Stage"."</td>";
    }
    if($data['outcome']==0){
      $row .= "<td>";
      $row .= "<form method=\"post\">";
      $row .= "<select name =\"result\">";
      $row .= "<option value=\"".$data['id'].",1\">".get_full_name($data['member1_id'])."</option>";
      $row .= "<option value=\"".$data['id'].",2\">".get_full_name($data['member2_id'])."</option>";
      $row .= "<option value=\"".$data['id'].",3"."\">"."Draw"."</option>";
      $row .= "</select>";
      $row .= "<button class=\"btn btn-outline-dark my-2 my-sm-0 confirmResult\" type=\"submit\" name=\"submitMatch\">Confirm</button>";
      $row .= "</form>";
    }
    $row .="</tr>";
    echo $row;
  }
}

?>




</tbody>
</table>

           </div>
         </div>
         

      </body>
</html>

 <?php
include( SHARED_PATH . '/footer.php' );
?>
