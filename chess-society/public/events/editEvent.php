<?php
session_start();
require_once('../../private/initialise.php');

$event_title = ""; $titleerror = "";
$event_description = ""; $description_error = "";
$event_expiry = ""; $expiryerror = "";
$errors = array();
$id = (int)($_GET['id'] ?? -1);
$events = find_event_by_id($id);
if ($id == -1) {
  redirect_to(url_for('/events/eventsTab.php'));
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $event_title = $_POST['event_title'];
		if(empty($event_title)) {
			$titleerror = "Title is required";
			array_push($errors, $titleerror);
		}
  $event_description = $_POST['events_description'];
		if(empty($event_description)) {
			$description_error = "Description is required";
			array_push($errors, $description_error);
		}
  $event_expiry = $_POST['expiry'];
		if(empty($event_expiry)) {
			$expiryerror = "Date of expiry is required";
			array_push($errors, $expiryerror);
	  }

  if(count($errors) == 0) {
  	$eventItem = [];
    $eventItem['id'] = $events['id'];
  	$eventItem['title'] = $event_title;
  	$eventItem['description'] = $event_description;
  	$eventItem['expiry_date'] = $event_expiry;

	  update_event($eventItem);
    $_SESSION['eventtitle'] = $event_title;
    $_SESSION['added'] = "You have successfully updated news";
    $_SESSION['eventdescription'] = $event_description;

    header('LOCATION: eventsTab.php');
  }
}
?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title> Edit Event Item </title>
</head>

<body>
  <div class = "container">
    <div class ="jumbotron">
      <h3 class="text">Edit Event</h3> </br>
      <form method="post" action ="">
        <?php include(PRIVATE_PATH . '/errors.php'); ?>
        <div class="form-group">
          <label for="event_title">Event Title</label>
          <input type="text" required="required" class="form-control" name="event_title" value="<?php echo $event_title; ?>" required>
          <span class="error"><?php echo $titleerror; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="event_description">Description</label>
          <input type="text" required="required" class="form-control" name="events_description" value="<?php echo $event_description;?>" required>
          <span class="error"><?php echo $description_error; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="event_expiry">Expiry Date</label>
          <input type="date" required="required" min= <?php echo date('Y-m-d'); ?> name="expiry" value="<?php echo $event_expiry; ?>" required>
          <span class="error"><?php echo $expiryerror; ?> </span> </br> </br>
        </div>
        <button type="submit" class="btn btn-primary">Update event</button>
        <a href="<?php echo url_for('/events/eventsTab.php'); ?>">&laquo; Back to list of events</a>
      </form>
    </div>
  </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php');?>
