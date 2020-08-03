<?php
session_start();
require_once('../private/initialise.php');
?>
<?php
include(SHARED_PATH . '/memberheader.php');
?>

<!DOCTYPE html>
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
          <div class ="container">
           <table class="table-responsive" style="margin-left:auto ; margin-right:auto;" >


                <?php
echo "<table class=\"table table-striped table-hover\">";
echo "<thead class=\"thead-dark  \">
                     <th colspan=\"4\">Members</th>
                     </thead>
                     ";
echo "<thead class=\"thead-dark\">";
echo "<th>Name</th>" . "<th>LastName</th>" . "<th>Email</th><th>Officer</th>";
echo "</thead>";
echo "<tbody>";
$members = find_all_members();
$no      = 0;
if (mysqli_num_rows($members) > 0) {
    while ($row = mysqli_fetch_assoc($members)) {
        $res = $row['email'];
        $no  = $no + 1;
        echo "<tr>";
        echo "<td > " . h($row['fname']) . " </td>";
        echo "<td> " . h($row['lname']) . " </td>";
        echo "<td> <a href=\"" . url_for("members/profilepage.php") . "?email=$res    \"> " . h($res) . " </a> </td>";
        echo "<td>";
        if (isset($_POST['button' . $no]) && !officer_exists($row['id'])) {
            make_officer($row['id']);
        }
        if (isset($_POST['button' . (-1) * $no]) && officer_exists($row['id'])) {
            delete_officer($row['id']);
        }
        if (!officer_exists($row['id'])) {
            echo "  <div class=\"container\"> <form action=\"\" method=\"post\">
                              <button type=\"submit\" id=\"prom\" name=\"button" . ($no) . "\" class=\"btn btn-primary\">Promote</div> </form>";
            echo "</td>";
        } else {
            echo "  <div class=\"container\">
                                  <form action=\"\" method=\"post\">
                                <button type=\"grayed\" id=\"prom\" name=\"button" . ((-1) * $no) . "\" class=\"btn btn-secondary\">Demote</div>  </form>
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


 <?php
include(SHARED_PATH . '/footer.php');
?>
