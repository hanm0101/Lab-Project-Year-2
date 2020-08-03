
<?php require_once('../private/initialise.php'); ?>
<?php
session_start();
 include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
      <head>
           <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
           <meta charset="utf-8">

           <script src="jquery.js"></script>
           <script src="js/bootstrap.js"></script>
           <link href="css/bootstrap.css" rel="stylesheet" />
      </head>
      <body>
          <div class ="container">
           <div class="table-responsive" style="margin-left:auto ; margin-right:auto;" >


                <?php




                    echo "<table class=\"table table-striped table-hover\">";
                    echo "<thead class=\"thead-dark  w-100\">
                     <th colspan=\"4\">Organisers</th>
                     </thead>
                     ";
                    echo "<thead class=\"thead-dark\">";
                    echo "<tr>";
                    echo "<th>Name</th>"."<th>LastName</th>"."<th>Email</th><th>Officer</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                      $members = find_all_officers_as_members();
                    $no = 0;
                    if(mysqli_num_rows($members) > 0)
                   {
                     while($row = mysqli_fetch_assoc($members))
                     if($_SESSION['officer_id'] != $row['officer_id'])
                     {
                       $res = $row['email'];
                        $no = $no +1;
                          echo "<tr>";
                          echo "<td> "  .h($row['fname']).  " </td>";
                          echo "<td> "  .h($row['lname']).  " </td>";
                          echo "<td> <a href=\"" . url_for("members/profilepage.php") . "?email=$res    \"> "  .h($res).  " </a> </td>";
                          echo "<td>";

                          if(isset($_POST['button'.$no]) && !is_organiser($_GET['id'],$row['officer_id'])){
                            insert_tournament_organiser($row['officer_id'],$_GET['id']);


                          }
                          if(isset($_POST['button'.(-1)*$no]) && is_organiser($_GET['id'],$row['officer_id'])){
                          delete_organiser($_GET['id'],$row['officer_id']);

                          }


                          if(!is_organiser($_GET['id'],$row['officer_id'])   ){

                          echo "  <div class=\"container\"> <form action=\"\" method=\"post\">



                              <button type=\"submit\" id=\"prom\" name=\"button".($no)."\" class=\"btn btn-primary\">Make Organiser</div> </form>
                              ";
                          echo "</td>";
                        }else {
                          echo "  <div class=\"container\">
                                  <form action=\"\" method=\"post\">




                                <button type=\"grayed\" id=\"prom\" name=\"button".((-1)*$no)."\" class=\"btn btn-secondary\">Remove Organiser</div>  </form>
                                ";
                            echo "</td>";
                            //Add demote function
                        }
                          echo "</tr";
                          echo "</tr>";
                     }
                     echo "</tbody>";
                     echo "</table>";
                  }
                ?>




           </div>
         </div>


 <?php include(SHARED_PATH . '/footer.php'); ?>
