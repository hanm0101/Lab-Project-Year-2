<?php
  session_start();

  require_once('../../private/initialise.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SESSION['username'])) {
      delete_member($_SESSION['username']);
    }
    if(isset($_SESSION['email'])) {
      delete_member($_SESSION['email']);
    }
    header('location: ' . url_for('logout.php'));
  }
?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title> Profile Page </title>
</head>

<body>
 <div class = "container">
  <div class ="jumbotron">
   <form method="post" action ="">
     <h5> Are you sure you want to remove yourself as a member of the chess society? </h5>

     <div class="form-group">
      <button type="submit" class="btn btn-primary" name="submit">Yes</button>
      <a class="btn btn-primary" href ="profilepage.php"> No </a> </br>
     </div>
   </form>
 </div>
</div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>
