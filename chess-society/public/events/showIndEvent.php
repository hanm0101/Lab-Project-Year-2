<?php
session_start();
require_once('../../private/initialise.php');

  $id = (int)($_GET['id'] ?? -1);

  //if ($id == -1) {
      //redirect_to(url_for('/news/newsTab.php'));
  //}
  $eventsItem = find_event_by_id($id);
?>

<a href="<?php echo url_for('/events/eventsTab.php'); ?>">&laquo; Back to list of events</a>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title>Event </title>
  <script src="jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <link href="css/bootstrap.css" rel="stylesheet" />
</head>

<body>
 <div class="table-responsive">
   <div class ="jumbotron">
     <h2 class="text-center">Events</h2>
     <div class = "container" align="right">
       <?php if( isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ]) : ?>
       <a class="btn btn-primary" href = "<?php echo url_for('events/editEvent.php?id=' . h($eventsItem['id'])); ?>"> Edit event</a>
       <a class="btn btn-primary" href = "<?php echo url_for('events/deleteEvent.php?id=' . h($eventsItem['id'])); ?>"> Delete evnet</a></br> </br>
       <?php endif; ?>
     </div>

       <table class="table table-striped table-hover">
         <thead class="thead-dark">
           <tr>
             <th>Event Title</th>
             <th>Description</th>
             <th>Expiry Date</th>
           </tr>
         </thead>
         <tbody>
           <tr>
             <td><?php echo h($eventsItem["title"]); ?></td>
             <td><?php echo h($eventsItem["description"]); ?></td>
             <td><?php echo h($eventsItem["expiry_date"]); ?></td>
           </tr>
         </tbody>
       </table>
     </div>
   </div>
 </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>
