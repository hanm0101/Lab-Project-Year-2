<?php
  session_start();
  require_once('../../private/initialise.php');
  $currentpassword = ""; $currentpassworderror = "";
  $password_1 = ""; $password_1error = "";
  $password_2 = ""; $password_2error = ""; $confirmpassworderror = "";
  $errors = array();
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
      $currentpassword = $_POST['currentpassword'];
        if(isset($_SESSION['username'])) {
          $row = find_member_password_by_email($_SESSION['username']);
          $oldpassworddb = $row['password'];
        }
        else if(isset($_SESSION['email'])) {
          $row = find_member_password_by_email($_SESSION['email']);
          $oldpassworddb = $row['password'];
        }

        if(empty($currentpassword)) {
          $currentpassworderror = "Password is required";
          array_push($errors, $currentpassworderror);
        }
        else if(password_verify($currentpassword, $oldpassworddb) == false) {
          $currentpassworderror = "Password does not match your current password";
          array_push($errors, $currentpassworderror);
        }
      $password_1 = $_POST['password_1'];
        if(empty($password_1)) {
          $password_1error = "Password is required";
          array_push($errors, $password_1error);
        }
        else if(strlen($password_1) < '6') {
          $password_1error = "Password must be at least 6 characters";
          array_push($errors, $password_1error);
        }
      $password_2 = $_POST['password_2'];
        if(empty($password_2)) {
          $password_2error = "Confirmed password is required";
          array_push($errors, $password_2error);
        }
        else if(strlen($password_2) < '6') {
          $password_2error = "Password must be at least 6 characters";
          array_push($errors, $password_2error);
        }
        if($password_1 != $password_2) {
    			$confirmpassworderror = "Passwords do not match";
    			array_push($errors, $confirmpassworderror);
    	  }
      if(count($errors) == 0) {
        $passwordHash = password_hash($password_1, PASSWORD_DEFAULT);
        $member = [];
        if(isset($_SESSION['username'])) {
          $member['email'] = $_SESSION['username'];
        }
        else if(isset($_SESSION['email'])) {
          $member['email'] = $_SESSION['email'];
        }
    		$member['password'] = $passwordHash;
    		update_member_password($member);
        header('location: profilepage.php');
      }
    }
  }
  ?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>

  <!DOCTYPE html>
  <html>
  <head>
   <title> Member Profile </title>
   <meta charset = "utf-8">
  </head>

  <body>
    <div class = "container">
      <div class ="jumbotron">
        <h3 class="text">Change password</h3> </br>
        <form method="post" action ="">
           <?php include(PRIVATE_PATH . '/errors.php'); ?>
           <div class="form-group">
             <label>Current password:</label>
             <input type="password" name="currentpassword" >
      		   <span class="error"><?php echo $currentpassworderror; ?> </span> </br> </br>
           </div>
           <div class="form-group">
             <label>New password:</label>
             <input type="password" name="password_1" >
      		   <span class="error"><?php echo $password_1error; ?> </span> </br> </br>
           </div>
           <div class="form-group">
             <label>Confirm new password:</label>
             <input type="password" name="password_2" >
      		   <span class="error"><?php echo $password_2error; ?> </span> </br>
      			 <span class="error"><?php echo $confirmpassworderror; ?> </span> </br> </br>
           </div>
           <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit">Confirm update password</button>
           </div>
         </form>
       </div>
     </div>
    </body>
  </html>

  <?php include(SHARED_PATH . '/footer.php'); ?>
