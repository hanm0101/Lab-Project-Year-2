<?php
  session_start();
  require_once('../../private/initialise.php');
  if(!(isset($_GET['email']))) {
    if(isset($_SESSION['username'])) {
      $member = find_member_by_email($_SESSION['username']);
    }
    if(isset($_SESSION['email'])) {
      $member = find_member_by_email($_SESSION['email']);
    }
  }
  else {
    $member = find_member_by_email($_GET['email']);
  }
?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title> Profile Page </title>
  <script src="jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <link href="css/bootstrap.css" rel="stylesheet" />
  <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
      <script type = "text/javascript">
         google.load("visualization", "1", {packages: ["corechart"]});
      </script>
  
</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
   <a class="navbar-brand" href="#">Profile Page</a>
  <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    <li class="nav-item">
      <a class="nav-link" href = "<?php echo url_for('members/editprofile.php'); ?>">Edit Profile</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href = "<?php echo url_for('members/changePassword.php'); ?>">Change Password</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href = "<?php echo url_for('members/myMatches.php'); ?>">Match History</a>
    </li>
   
    <li class="nav-item">
    <a class="nav-link" href = "<?php echo url_for('members/eloHistory.php'); ?>">View Elo History</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href = "<?php echo url_for('members/eloDistribution.php'); ?>">Society Elo Distribution</a>
    <li class="nav-item">
    <a button class="btn btn-outline-danger my-2 my-sm-0" href = "<?php echo url_for('members/deleteMember.php');?>">Delete Account</a>
    </li>
    </li>
    
  </ul>
  <?php if(isset($_SESSION['isOfficer']) && $_SESSION['isOfficer']) :?>
  <form class="form-inline" method="POST">
  <input type="email" name="banEmail" pattern="([a-zA-Z0-9_]+\.[a-zA-Z0-9_]+@kcl.ac.uk$)|(k+[0-9]+@kcl.ac.uk)" placeholder="email to ban" required>    
    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="submit">Ban</button>
  </form>
  <?php endif; ?>
</nav>
<br>


 <div class="table-responsive">
   
    

       <table class="table table-striped table-hover">
         <thead class="thead-dark">
           <tr>
             <th>First name</th>
             <th>Last name</th>
             <th>Gender</th>
             <th>Date of birth</th>
             <th>Address</th>
             <th>Phone number</th>
             <th>Email</th>
             <th>Elo rating</th>
           </tr>
         </thead>
         <tbody>
           <tr>
             <td><?php echo h($member["fname"]); ?></td>
             <td><?php echo h($member["lname"]); ?></td>
             <td><?php
        					switch (h($member["gender"])) {
        						case 1:
        							echo "Male";
        							break;
        						case 2:
        							echo "Female";
        							break;
        						case 3:
        							echo "Other";
        					} ?>
    		     </td>
             <td><?php echo h($member["DoB"]); ?></td>
             <td><?php echo h($member["address"]); ?></td>
             <td><?php echo h($member["phone_no"]); ?></td>
             <td><?php echo h($member["email"]); ?></td>
             <td><?php echo h($member["elo"]); ?></td>
           </tr>
         </tbody>
       </table>
     </div>
   </div>
 </div>

</body>
<?php           if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['banEmail']))
{

  insert_banned($_POST['banEmail']);   } 
      ?>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>
