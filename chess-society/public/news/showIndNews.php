<?php
session_start();
require_once('../../private/initialise.php');

  $id = (int)($_GET['id'] ?? -1);

  //if ($id == -1) {
      //redirect_to(url_for('/news/newsTab.php'));
  //}
  $newsItem = find_news_by_id($id);
?>

<a href="<?php echo url_for('/news/showAllNews.php'); ?>">&laquo; Back to list of news</a>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title>News </title>
  <script src="jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <link href="css/bootstrap.css" rel="stylesheet" />
</head>

<body>
 <div class="table-responsive">
   <div class ="jumbotron">
     <h2 class="text-center">News</h2>
     <div class = "container" align="right">
       <?php if( isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ]) : ?>
       <a class="btn btn-primary" href = "<?php echo url_for('news/editNews.php?id=' . h($newsItem['id'])); ?>"> Edit news</a>
       <a class="btn btn-primary" href = "<?php echo url_for('news/newsDelete.php?id=' . h($newsItem['id'])); ?>"> Delete news</a></br> </br>
       <?php endif; ?>
     </div>

       <table class="table table-striped table-hover">
         <thead class="thead-dark">
           <tr>
             <th>News Title</th>
             <th>Description</th>
             <th>Expiry Date</th>
           </tr>
         </thead>
         <tbody>
           <tr>
             <td><?php echo h($newsItem["title"]); ?></td>
             <td><?php echo h($newsItem["description"]); ?></td>
             <td><?php echo h($newsItem["expiry_date"]); ?></td>
           </tr>
         </tbody>
       </table>
     </div>
   </div>
 </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>
