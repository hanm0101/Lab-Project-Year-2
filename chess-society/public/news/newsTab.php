<?php
  require_once('../../private/initialise.php');
  session_start();
?>
<?php
  if(isset($_SESSION['id'])) {
    $officer = find_officer_by_id($_SESSION['']);
    include('officerNewsShow.php');
  } else {
    include('showAllNews.php');
  }
?>

<?php /*
  if (is_post_request()) {
    $newsItem = [];
    $newsItem['title'] = $_POST['title'] ?? '';
    $newsItem['description'] = $_POST['description'] ?? '';
    $newsItem['expiry_date'] = $_POST['expiry_date'] ?? '0';
    $result = insert_news($newsItem);
    if ($result === true) {
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('showAllNews.php?id=' . $id));
    } else {
        $errors = $result;
    }
  } else {
    $newsItem = [];
  }*/
?>

<?php include(SHARED_PATH . '/footer.php'); ?>
