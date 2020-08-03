<?php
session_start();
require_once( '../private/initialise.php' );
?>
 <?php
 include(SHARED_PATH . '/memberheader.php');
?>



<html>



      <body >

      <div class="container w-75">
           <table class="table-responsive  w-75" style="margin-left:auto ; margin-right:auto;"  >

             <table class="table table-striped table-hover mx-auto w-auto "  >

               <?php

if ( isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ] == true ) {
				$dateError = "";
				$title     = "";
				$desc      = "";
				$date      = "";
				$dead      = "";
				if ( isset( $_POST[ 'submit' ] ) ) {
								if ( $_POST[ 'deadline' ] > $_POST[ 'tournament_date' ] ) {
												$dateError .= "Deadline must come before the date";
												$title = $_POST[ 'title' ];
												$desc  = $_POST[ 'description' ];
												$date  = $_POST[ 'tournament_date' ];
												$dead  = $_POST[ 'deadline' ];
								} //$_POST[ 'deadline' ] < $_POST[ 'tournament_date' ]
								else {
												insert_tournament( $_POST, $_SESSION[ 'officer_id' ] );
								}
				} //isset( $_POST[ 'submit' ] )
				echo <<< END_OF_TEXT
 <thead class="thead-light">
                   <tr>
                   <thead class="thead-dark  w-100">
                    <th colspan="5">Tournaments</th>
                    </thead>
                     <th colspan="5">
                     <details>
                     <summary>Add a new tournament</summary>

                     <table class="table">
                     <tbody>
                     <th>
                     <div class="form-group">
                        <form action="" method="post">


                       <input type="text" name="title" value="$title" required>

                      </th>
                      <th>


                        <input type="text" name="description" value="$desc" required>

                       </th>
                       <th>


                         <input type="date" name="deadline" value=$dead required>
                          <span class="overlay"> $dateError</span> </br> </br>
                         </th>

                       <th>


                         <input type="date" name="tournament_date" value=$date required>


                        </th>


                        <th> <input type="submit" name ="submit"
        />
       </th></form>

                         </div>


                     </tbody>
                      </div>



                   </table>
                   </details>
                 </th>


                  </tr>
                 </thead>
END_OF_TEXT;
} //isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ] == true
?>
             <thead class="thead-dark  w-100">
             <tr>
             <th>Title</th><th>Description</th><th>Deadline</th><th>Date</th><th>Register</th>


              </tr>
             </thead>


              <tbody>

                <?php
$tours = find_all_tournaments();
$no      = 0;
$curDate = date("Y-m-d");

if ( mysqli_num_rows( $tours ) > 0 ) {
				while ( $row = mysqli_fetch_assoc( $tours ) ) {
                $no++;
								$id = $row[ 'id' ];
								echo "<tr>";
								echo "<td><a href=\"" . url_for("tournamentDetails.php") . "?id=$id    \"> " . h( $row[ 'title' ] ) . " </td>";
								echo "<td> " . h( $row[ 'description' ] ) . " </td>";
                	echo "<td> " . h( $row[ 'deadline' ] ) . " </td>";
								echo "<td> " . h( $row[ 'tournament_date' ] ) . " </td>";
                echo "<td>";
                if ( isset( $_POST[ 'button' . $no ] ) && !is_in_tournament($_SESSION['id'],$id) ) {
                       $mem = find_member_by_ID($_SESSION['id']);
												$newMem = array(
																 "member_id" => $_SESSION['id'],
																"tournament_id" => $id,
																"elo_before" => $mem[ 'elo' ],
																"elo_after" => -1
												);
												insert_tournament_member( $newMem );
								}
                if ($curDate<$row['deadline'] && !is_in_tournament($_SESSION['id'],$id) && empty(find_matches_by_tournament($row['id']))) {
                    echo "  <div class=\"container\"> <form action=\"\" method=\"post\">



                                      <button type=\"submit\" id=\"prom\" name=\"button" . ($no) . "\" class=\"btn btn-secondary\">Sign Up</div> </form>";



                }
                echo "</td>";
								echo "</tr";
								echo "</tr>";
				} //$row = mysqli_fetch_assoc( $members )
} //mysqli_num_rows( $members ) > 0
?>
              </tbody>
                  </table>



           </div>
</body>


 <?php
include( SHARED_PATH . '/footer.php' );
?>
