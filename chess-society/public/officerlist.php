<?php
session_start();
require_once('../private/initialise.php');
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
           <div class ="container w-80">
            <div class="table-responsive w-80" style="margin-left:auto ; margin-right:auto;" >




                <?php
$officers = find_all_officers_as_members();
echo "<table class=\"table table-striped table-hover\">";
echo "<thead class=\"thead-dark\">";
echo "<tr>
<th colspan=\"4\">Officers</th>
</tr>";
echo "<tr>";
echo "<th>Name</th>" . "<th>LastName</th>" . "<th>Email</th><th></th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
if (mysqli_num_rows($officers) > 0) {
    $no = 0;
    while ($row = mysqli_fetch_assoc($officers)) {
        $no += 1;
        if (isset($_POST['button' . $no]) && officer_exists($row['id'])) {
            delete_officer($row['id']);
        } else if (officer_exists($row['id'])) {
            $res = $row['email'];
            echo "<tr>";
            echo "<td> " . h($row['fname']) . " </td>";
            echo "<td> " . h($row['lname']) . " </td>";
            echo "<td> <a href=\"" . url_for("members/profilepage.php") . "?email=$res    \"> " . h($res) . " </a> </td>";
            echo "<td>";
            echo "  <div class=\"container\"> <form action=\"\" method=\"post\">
                             <button type=\"submit\" id=\"prom\" name=\"button" . ($no) . "\" class=\"btn btn-secondary\">Demote</div> </form>
                             ";
            echo "</td>";
            echo "</tr";
            echo "</tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";
}
?>



           </div>
      </body>
 </html>

 <?php
include(SHARED_PATH . '/footer.php');
?>
