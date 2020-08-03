<?php require_once('../private/initialise.php'); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<!DOCTYPE html>
<html>
<body>
  <div class="container">
    <div class ="jumbotron">
      <h3 class="text-center">Login</h3>
      <form action="" method="post">
        <div class="form-group">
          <label for="email">Email Adress:</label>
          <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="pass">Password:</label>
          <input type="password" class="form-control" id="pass" name="password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Login</button>

        <?php
        session_start();
          if(isset($_POST['submit'])){
            $username = $_POST['email'];
            $password = $_POST['password'];
            if(member_pass_correct($username, $password) == true) {
              $_SESSION['email'] = $username;
              $_SESSION['login'] = true;
              $_SESSION['id'] =email_to_ID($username)['id'];
              $_SESSION['isOfficer'] = officer_exists($_SESSION['id']);
              if($_SESSION['isOfficer'] == true){
                $_SESSION['officer_id'] = officer_member_to_id($_SESSION['id']);
              }
              header('LOCATION: members/membermainpage.php');
              die();
            }
            else {
              echo "<div class='alert alert-danger'>Your email and password do not match</div>";
            }
          }
        ?>
      </form>
    </div>
  </div>
</body>
</html>


<?php include(SHARED_PATH . '/footer.php'); ?>
