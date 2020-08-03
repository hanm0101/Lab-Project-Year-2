<?php
require_once('../private/initialise.php');
session_start();
$firstname = ""; $firstnameerror = "";
$lastname = ""; $lastnameerror = "";
$dob = ""; $doberror = "";
$gender = 3; $gendererror = "";
$address = ""; $addresserror = "";
$number = ""; $numbererror = "";
$email = ""; $emailerror = ""; $emailexisterror = "";
$password_1 = ""; $password_1error = "";
$password_2 = ""; $password_2error = ""; $confirmpassworderror = "";
 $emailBannedError ="";
$elo = "100";
$errors = array();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
  $email = $_POST['email'];
		if(empty($email)) {
			$emailerror = "Email address is required";
			array_push($errors, $emailerror);
	  }
		else if(!preg_match("/^[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+@kcl.ac.uk$/", $email) && !preg_match("/k+[0-9 ]+@kcl.ac.uk/", $email)) {
			$emailerror = "Only KCL email is allowed";
			array_push($errors, $emailerror);
		}
    if(is_banned($email)) {
        $member = find_member_by_email($email);
        if($member['email'] === $email) {
          $emailBannedError = "This email is banned";
          array_push($errors, $emailBannedError);
        }
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
			array_push($errors, $pa/ssword_2error);
		}
		else if(strlen($password_2) < '6') {
			$password_2error = "Password must be at least 6 characters";
			array_push($errors, $password_2error);
		}
		if($password_1 != $password_2) {
			$confirmpassworderror = "Passwords do not match";
			array_push($errors, $confirmpassworderror);
	  }
  if(is_banned($email)) {
      $member = find_member_by_email($email);
      if($member['email'] === $email) {
        $emailBannedError = "This email is banned";
        array_push($errors, $emailBannedError);
      }
    }
  if(member_exists($email)) {
	  $member = find_member_by_email($email);
    if($member['email'] === $email) {
			$emailexisterror = "This email already exists";
			array_push($errors, $emailexisterror);
    }
  }
  if(count($errors) == 0 && !is_banned($email)) {
  	$passwordHash = password_hash($password_1, PASSWORD_DEFAULT);
  	$member = [];
  	$member['email'] = $email;
  	$member['password'] = $passwordHash;
  	$member['fname'] = $firstname;
  	$member['lname'] = $lastname;
  	$member['address'] = $address;
  	$member['phone_no'] = $number;
  	$member['gender'] = $gender;
  	$member['dob'] = $dob;
	  insert_member($member);

    $_SESSION['email'] = $email;
    $_SESSION['success'] = "You have successfully signed up as a member";
    $_SESSION['login'] = true;
    $_SESSION['id'] =email_to_ID($email)['id'];
    $_SESSION['isOfficer'] = officer_exists($_SESSION['id']);
    if($_SESSION['isOfficer'] == true){
      $_SESSION['officer_id'] = officer_member_to_id($_SESSION['id']);
    }

    header('location: members/membermainpage.php');
  }
}
?>

<?php include(SHARED_PATH . '/header.php'); ?>

<!DOCTYPE html>
<html>
<head>
 <title> Sign up form </title>
</head>

<body>
 <div class = "container">
   <div class ="jumbotron">
     <h3 class="text">Registration form</h3> </br>
     <form method="post" action ="">
       <?php include('../private/errors.php'); ?>
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
         <input type="tel" name="phonenumber" value="<?php echo $number; ?>" pattern= "^[0-9]+"required>
  		   <span class="error"><?php echo $numbererror;?> </span> </br> </br>
       </div>
       <div class="form-group">
         <label>Email address:</label>
         <input type="email" name="email" pattern="([a-zA-Z0-9_]+\.[a-zA-Z0-9_]+@kcl.ac.uk$)|(k+[0-9]+@kcl.ac.uk)" value="<?php echo $email; ?>" required>
  			 <span class="error"><?php echo $emailerror; ?> </span>
         <span class="error"><?php echo $emailBannedError; ?> </span>
  		   <span class="error"><?php echo $emailexisterror; ?> </span> </br> </br>
       </div>
       <div class="form-group">
         <label>Password:</label>
         <input type="password" name="password_1" >
  		   <span class="error"><?php echo $password_1error; ?> </span> </br> </br>
       </div>
       <div class="form-group">
         <label>Confirm password:</label>
         <input type="password" name="password_2" >
  		   <span class="error"><?php echo $password_2error; ?> </span> </br>
  			 <span class="error"><?php echo $confirmpassworderror; ?> </span> </br> </br>
       </div>
  	   <div class="form-group">
        <button type="submit" class="btn btn-primary" name="submit">Sign up</button>
       </div>
     </div>
   </form>
 </div>
</body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>
