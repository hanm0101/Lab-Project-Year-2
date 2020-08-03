<?php
  session_start();
  require_once('../../private/initialise.php');
  $firstname = ""; $firstnameerror = "";
  $lastname = ""; $lastnameerror = "";
  $gender = 3; $gendererror = "";
  $dob = ""; $doberror = "";
  $address = ""; $addresserror = "";
  $number = ""; $numbererror = "";
  $errors = array();
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
      $firstname = $_POST['firstname'];
    		if(empty($firstname)) {
    			$firstnameerror = "First name is required";
    			array_push($errors, $firstnameerror);
    		}
    		else if(!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
    			$firstnameerror = "Only letters and white space are allowed";
    			array_push($errors, $firstnameerror);
    		}
      $lastname = $_POST['lastname'];
    		if(empty($lastname)) {
    			$lastnameerror = "Last name is required";
    			array_push($errors, $lastnameerror);
    		}
    		else if(!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
    			$lastnameerror = "Only letters and white space are allowed";
    			array_push($errors, $lastnameerror);
    		}
      $gender = $_POST['gender'];
    		if(empty($gender)) {
    			$gendererror = "Gender is required";
    			array_push($errors, $gendererror);
    	  }
      $dob = $_POST['dob'];
    		if(empty($dob)) {
    			$doberror = "Date of birth is required";
    			array_push($errors, $doberror);
    	  }
      $address = $_POST['address'];
    		if(empty($address)) {
    			$addresserror = "Address is required";
    			array_push($errors, $addresserror);
    	  }
      $number = $_POST['phonenumber'];
    		if(empty($number)) {
    			$numbererror = "Phone number is required";
    			array_push($errors, $numbererror);
    	  }
    		else if(!preg_match("/[0-9 ]/", $number)) {
    			$numbererror = "Only numbers are allowed";
    			array_push($errors, $numbererror);
    		}

      if(count($errors) == 0) {
        $member = [];
        if(isset($_SESSION['username'])) {
          $member['email'] = $_SESSION['username'];
        }
        else if(isset($_SESSION['email'])) {
          $member['email'] = $_SESSION['email'];
        }
    		$member['fname'] = $firstname;
    		$member['lname'] = $lastname;
    		$member['address'] = $address;
    		$member['phone_no'] = $number;
    		$member['gender'] = $gender;
    		$member['dob'] = $dob;
    		update_member($member);
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
      <h3 class="text">Update profile information</h3> </br>
      <form method="post" action ="">
         <?php include(PRIVATE_PATH . '/errors.php'); ?>
         <div class="form-group">
           <label>First Name:</label>
           <input type="text" name="firstname" value="<?php echo $firstname; ?>" required>
    			 <span class="error"><?php echo $firstnameerror; ?> </span> </br> </br>
    		 </div>
         <div class="form-group">
           <label>Last Name:</label>
           <input type="text" name="lastname" value="<?php echo $lastname; ?>" required>
    		 	 <span class="error"><?php echo $lastnameerror; ?> </span> </br> </br>
         </div>
         <div class="form-group">
    	     <label>Gender:</label>
           <input type="radio" class="radio-inline" name="gender" value=1 required>Male
      	   <input type="radio" class="radio-inline" name="gender" value=2 required>Female
      	   <input type="radio" class="radio-inline" name="gender" value=3 required>Other
           <span class="error"><?php echo $gendererror; ?> </span> </br> </br>
         </div>
         <div class="form-group">
    	     <label>Date of Birth </label>
           <input type="date" required="required" max= <?php echo date('Y-m-d'); ?> name="dob" value="<?php echo $dob; ?>" required>
    		   <span class="error"><?php echo $doberror; ?> </span> </br> </br>
         </div>
         <div class="form-group">
           <label>Address:</label>
           <input type="text" name="address" value="<?php echo $address; ?>" required>
    		   <span class="error"><?php echo $addresserror; ?> </span> </br> </br>
         </div>
         <div class="form-group">
           <label>Phone number:</label>
           <input type="tel" name="phonenumber" value="<?php echo $number; ?>" required>
    		   <span class="error"><?php echo $numbererror;?> </span> </br> </br>
         </div>
    	   <div class="form-group">
          <button type="submit" class="btn btn-primary" name="submit">Confirm update</button>
         </div>
       </form>
     </div>
   </div>
  </body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>
