<?php
  session_start();
  require_once('../private/initialise.php');
  include(SHARED_PATH . '/header.php');
  $_SESSION['login'] = false;
?>

<!doctype html>
<html lang="en">
  <body>
    <div class="container">
      <div class ="jumbotron">
        <div class = "container">
          <h2 class = "title"> About us </h2>
          <p>Hello and welcome to the KCL Chess Society. As a society made exclusively for staff or students in King's College,
              we host events and tournaments all dedicated to the game of chess. If you are a member of KCL and wish to join, feel free to
              signup to this website and have a look at our upcoming events and tournaments.</p>
         </div>
         <div class = "container">
           <h2 class = "title"> Signing Up</h2>
           <p>Signing up lets you participate in all events
              and tournaments we organise and will keep a track of your Elo rating as you participate in the society.</p>
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
