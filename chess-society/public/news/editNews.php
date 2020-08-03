<?php
session_start();
require_once('../../private/initialise.php');

$news_title = ""; $titleerror = "";
$news_description = ""; $description_error = "";
$news_expiry = ""; $expiryerror = "";
$errors = array();
$id = (int)($_GET['id'] ?? -1);
$news = find_news_by_id($id);
if ($id == -1) {
  redirect_to(url_for('/news/showAllNews.php'));
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $newsItem['id'] = $news['id'];
  	$newsItem['title'] = $news_title;
  	$newsItem['description'] = $news_description;
  	$newsItem['expiry_date'] = $news_expiry;


	  update_news($newsItem);
    $_SESSION['title'] = $news_title;
    $_SESSION['added'] = "You have successfully updated news";
    $_SESSION['description'] = $news_description;

    header('LOCATION: showAllNews.php');
  }
}
?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title> Edit News Item </title>
</head>

<body>
  <div class = "container">
    <div class ="jumbotron">
      <h3 class="text">Edit News Item</h3> </br>
      <form method="post" action ="">
        <?php include(PRIVATE_PATH . '/errors.php'); ?>
        <div class="form-group">
          <label for="news_name">News Title</label>
          <input type="text" required="required" class="form-control" name="news_title" value="<?php echo $news_title; ?>" required>
          <span class="error"><?php echo $titleerror; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="news_description">Description</label>
          <input type="text" required="required" class="form-control" name="news_description" value="<?php echo $news_description;?>" required>
          <span class="error"><?php echo $description_error; ?> </span> </br> </br>
        </div>
        <div class="form-group">
          <label for="news_expiry">Expiry Date</label>
          <input type="date" required="required" min= <?php echo date('Y-m-d'); ?> name="expiry" value="<?php echo $news_expiry; ?>" required>
          <span class="error"><?php echo $expiryerror; ?> </span> </br> </br>
        </div>
        <button type="submit" class="btn btn-primary">Update news</button>
        <a href="<?php echo url_for('/news/showAllNews.php'); ?>">&laquo; Back to list of news</a>
      </form>
    </div>
  </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php');?>
