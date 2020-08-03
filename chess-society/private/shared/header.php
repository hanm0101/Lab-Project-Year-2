<!DOCTYPE html>
<html>
<head>
  <?php if (!isset($page_title)) { $page_title = ""; } ?>
  <title>Chess Society | <?php echo $page_title; ?></title>
  <meta charset = "utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="<?php echo url_for("stylesheets/style.css"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
<div class="container1">
  <div class="jumbotron jumbotron-fluid jumbotron-first">
    <div class="row">
      <div class = "col-md-2">
        <img class ="img-responsive1" src="<?php echo url_for("images/kcl.png"); ?>" width="140" />
      </div>
      <div class="col-md-4">
        <h1 class="display-4">KCL Chess Society</h1>
      </div>
      <div class = "col-md-1">
        <img class="img-responsive" src="<?php echo url_for("images/chess1.jpg"); ?>"   />
      </div>
      <div class= "bottom-right">
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
          <a href="<?php echo url_for("mainpage.php"); ?>" button type="button" class="btn btn-secondary">Home</button></a>
          <a href="<?php echo url_for("news/showAllNews.php"); ?>" button type="button" class="btn btn-secondary">News</button></a>
			  	<a href="<?php echo url_for("signup.php"); ?>"button type="button" class="btn btn-secondary">Signup</button></a>
				  <a href="<?php echo url_for("login.php"); ?>"button type="button" class="btn btn-secondary">Login</button></a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
