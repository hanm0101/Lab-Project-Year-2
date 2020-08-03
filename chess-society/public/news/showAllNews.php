 <?php
 session_start();

 require_once('../../private/initialise.php');

 if($_SESSION['login'] == true) {
   include(SHARED_PATH . '/memberheader.php');
 }
 else {
   include(SHARED_PATH . '/header.php');
 }

 ?>

 <!DOCTYPE html>
 <html>
  <head>
      <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">
      <title>News</title>
      <script src="jquery.js"></script>
      <script src="js/bootstrap.js"></script>
      <link href="css/bootstrap.css" rel="stylesheet" />
  </head>

  <body>
    <div class ="container">
      <table class="table-responsive" style="margin-left:auto ; margin-right:auto;" >


      <?php
        echo "<table class=\"table table-striped table-hover\">";
        echo "<thead class=\"thead-dark  \">
              <th colspan=\"5\">News</th>
              </thead>
              ";
        echo "<thead class=\"thead-dark\">";
        echo "<th>Index</th><th>Title</th>" . "<th>Description</th>" . "<th>Expiry Date</th><th>Officer</th>";
        echo "</thead>";
        echo "<tbody>";

        $news = find_all_news();
        $no = 0;
        $item_displayed = false;
        if (mysqli_num_rows($news) > 0) {
          while ($row = mysqli_fetch_assoc($news)) {

            if($row['expiry_date'] > date('Y-m-d')){
              $item_displayed = true;
              $res = $row['officer_id'];
              $idRes = $row['id'];
              $no = $no + 1;
              echo "<tr>";
              echo "<td> <a href=\"" . url_for("news/showIndNews.php") . "?id=$idRes    \"> " . h($idRes) . " </a> </td>";
              echo "<td > " . h($row['title']) . " </td>";
              echo "<td> " . h($row['description']) . " </td>";
              echo "<td> " . h($row['expiry_date']) . " </td>";
              echo "<td> " . h($row['officer_id']) . " </td>";

              echo "</tr";
              echo "</tr>";
            }
          }
          echo "</tbody>";
          echo "</table>";
        }
    ?>
   <?php if($_SESSION['login'] == true && isset( $_SESSION[ 'isOfficer' ] ) && $_SESSION[ 'isOfficer' ]) : ?>
     <a class="btn btn-primary" href = "<?php echo url_for('news/newsAdd.php'); ?>">Add News</a>
   <?php endif; ?>
  </div>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
