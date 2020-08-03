<?php
session_start();
require_once('../../private/initialise.php');

$events_title = ""; $titleerror = "";
$events_description = ""; $description_error = "";
$events_expiry = ""; $expiryerror = "";
$errors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  //$_SESSION['isOfficer'] = officer_exists($_SESSION['id']);
  //if($_SESSION['isOfficer'] == true){
    //$_SESSION['officer_id'] = officer_member_to_id($_SESSION['id']);
  //} else {
    //$officererror = "You are not authorized to create news."
    //array_push($errors, $officererror);
  //}
// if (isset($_POST['title'])) {
//     $news_title = $_POST['title'];
// }
//
// if (isset($_POST['description'])) {
//     $news_description = $_POST['description'];
// }
//
// if (isset($_POST['expiry_date'])) {
//     $news_expiry = $_POST['expiry_date'];
// }
  $events_title = $_POST['event_title'];
		if(empty($events_title)) {
			$titleerror = "Title is required";
			array_push($errors, $titleerror);
		}
  $events_description = $_POST['events_description'];
		if(empty($events_description)) {
			$description_error = "Description is required";
			array_push($errors, $description_error);
		}
  $events_expiry = $_POST['expiry'];
		if(empty($events_expiry)) {
			$expiryerror = "Date of expiry is required";
			array_push($errors, $expiryerror);
	  }

  if(count($errors) == 0) {
  	$eventsItem = [];
  	$eventsItem['title'] = $events_title;
  	$eventsItem['description'] = $events_description;
  	$eventsItem['expiry_date'] = $events_expiry;
    $eventsItem['officer_id'] = $_SESSION['officer_id'];

	  insert_events($eventsItem);
    $_SESSION['eventstitle'] = $events_title;
    $_SESSION['eventsadded'] = "You have successfully created news";
    $_SESSION['eventsdescription'] = $events_description;

    header('LOCATION: eventsTab.php');
  }
}
?>
<?php// $page_title = "New News"; ?>
<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title> Create an Event </title>
</head>

<body>
  <div class = "container">
    <div class ="jumbotron">
      <h3 class="text">Add an event to the web system</h3> </br>
      <form method="post" action ="">
        <?php include(PRIVATE_PATH . '/errors.php'); ?>
        <div class="form-group">
          <label for="news_name">Event Title</label>
          <input type="text" required="required" class="form-control" name="event_title" value="<?php echo 'Type the title here' ?>" required>
          <span class="error"><?php echo $titleerror; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="news_description">Description</label>
          <input type="text" required="required" class="form-control" name="events_description" value="<?php echo 'Type the description here'?>" required>
          <span class="error"><?php echo $description_error; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="news_expiry">Expiry Date</label>
          <input type="date" required="required" min= <?php echo date('Y-m-d'); ?> name="expiry" required>
          <span class="error"><?php echo $expiryerror; ?> </span> </br> </br>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add Event</button>
        <a href="<?php echo url_for('/events/eventsTab.php'); ?>">&laquo; Back to list of events</a>
      </form>
    </div>
  </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php');?>
