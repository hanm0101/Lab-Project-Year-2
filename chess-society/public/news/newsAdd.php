<?php
session_start();
require_once('../../private/initialise.php');

$news_title = ""; $titleerror = "";
$news_description = ""; $description_error = "";
$news_expiry = ""; $expiryerror = "";
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
  $news_title = $_POST['news_title'];
		if(empty($news_title)) {
			$titleerror = "Title is required";
			array_push($errors, $titleerror);
		}
  $news_description = $_POST['news_description'];
		if(empty($news_description)) {
			$description_error = "Description is required";
			array_push($errors, $description_error);
		}
  $news_expiry = $_POST['expiry'];
		if(empty($news_expiry)) {
			$expiryerror = "Date of expiry is required";
			array_push($errors, $expiryerror);
	  }

  if(count($errors) == 0) {
  	$newsItem = [];
  	$newsItem['title'] = $news_title;
  	$newsItem['description'] = $news_description;
  	$newsItem['expiry_date'] = $news_expiry;
    $newsItem['officer_id'] = $_SESSION['officer_id'];

	  insert_news($newsItem);
    $_SESSION['title'] = $news_title;
    $_SESSION['added'] = "You have successfully created news";
    $_SESSION['description'] = $news_description;

    header('LOCATION: showAllNews.php');
  }
}
?>
<?php// $page_title = "New News"; ?>
<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title> Create News </title>
</head>

<body>
  <div class = "container">
    <div class ="jumbotron">
      <h3 class="text">Add News to the web system</h3> </br>
      <form method="post" action ="">
        <?php include(PRIVATE_PATH . '/errors.php'); ?>
        <div class="form-group">
          <label for="news_name">News Title</label>
          <input type="text" required="required" class="form-control" name="news_title" value="<?php echo 'Type the title here' ?>" required>
          <span class="error"><?php echo $titleerror; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="news_description">Description</label>
          <input type="text" required="required" class="form-control" name="news_description" value="<?php echo 'Type the description here'?>" required>
          <span class="error"><?php echo $description_error; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="news_expiry">Expiry Date</label>
          <input type="date" required="required" min= <?php echo date('Y-m-d'); ?> name="expiry" required>
          <span class="error"><?php echo $expiryerror; ?> </span> </br> </br>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add news</button>
        <a href="<?php echo url_for('/news/showAllNews.php'); ?>">&laquo; Back to list of news</a>
      </form>
    </div>
  </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php');?>
