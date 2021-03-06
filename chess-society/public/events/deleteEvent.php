<?php
session_start();
require_once('../../private/initialise.php');

  if (is_post_request()) {
    $id = (int)($_GET['id'] ?? -1);
    $eventItem = find_event_by_id($id);
    $result = delete_event($id);
    redirect_to(url_for('/events/eventsTab.php'));
  } else {
    $eventItem = find_event_by_id($id);
  }
?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title>Events </title>
</head>
<body>
 <div class = "container">
  <div class ="jumbotron">
   <form method="post" action ="">
     <h5> Are you sure you want to delete this event? </h5>
     <div class="form-group">
      <button type="submit" class="btn btn-primary" name="submit">Yes</button>
      <a class="btn btn-primary" href ="eventsTab.php"> No </a> </br>
     </div>
   </form>
 </div>
</div>
</body>


<?php include(SHARED_PATH . '/footer.php'); ?>
