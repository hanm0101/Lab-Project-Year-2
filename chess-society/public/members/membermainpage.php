<?php
  session_start();

  require_once('../../private/initialise.php');

  if(isset($_SESSION['username'])) {
    $member = find_member_by_id($_SESSION['username']);
  }


  if(isset($_SESSION['email'])) {
    $member = find_member_by_id($_SESSION['email']);
  }
?>


<!DOCTYPE html>
<html>
<head>
 <title> KCL Chess Society </title>
 <meta charset = "utf-8">
 <?php include(SHARED_PATH.'/memberheader.php'); ?>
</head>

 <body>
   <div class="container">
     <h2> Hello, <?php echo h($member['fname']); ?>! </h2>
     <div class ="jumbotron">
       <div class = "container">
         <h2 class = "title"> About us </h2>
         <p>Hello and welcome to the KCL Chess Society. As a society made exclusively for staff or students in King's College,
             we host events and tournaments all dedicated to the game of chess. If you are a member of KCL and wish to join, feel free to
             signup to this website and have a look at our upcoming events and tournaments.</p>
        </div>
        <div class = "container">
          <h2 class = "title"> Events and Tournaments </h2>
          <p>We regularly hold events and tournaments for our members to join. If you would like to know more about the details,
             feel free to click on the Events tab and Tournaments tab on the up right corner of the page.</p>
         </div>
        <div class = "container">
          <h2 class = "title">Elo</h2>
          <p>Elo is a method of calculating the relative chess skills of society members. Elo provides our members a way to monitor their
             improvement over time and have an incentive to be competitive and attend our events/tournaments more regularly to compete
             and increase their Elo.</p>
        </div>
     </div>
  </div>
</body>
</html>


<?php include(SHARED_PATH . '/footer.php'); ?>
