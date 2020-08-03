<?php
 session_start();

 if(isset($_SESSION['username']) || isset($SESSION['email'])) {
   $_SESSION['login'] = false;
   session_destroy();
 }
 header('location: mainpage.php');
?>
