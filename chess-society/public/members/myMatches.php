<?php
  session_start();

  require_once('../../private/initialise.php');

  if(!(isset($_GET['email']))) {
    if(isset($_SESSION['username'])) {
      $member = find_member_by_email($_SESSION['username']);
    }

    if(isset($_SESSION['email'])) {
      $member = find_member_by_email($_SESSION['email']);
    }
  }
  else {
    $member = find_member_by_email($_GET['email']);
  }
?>

<?php include(SHARED_PATH . '/memberheader.php'); ?>
<html>
   <head>
      <title>My Stats</title>
      <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
      <script type = "text/javascript">
         google.load("visualization", "1", {packages: ["corechart"]});
      </script>
   </head>
   
   <body>
   <table class="table table-striped table-hover">
<thead class="thead-dark">
<tr>
<th>Player 1</th><th>Player 2</th><th>Result</th><th>Tournament Stage</th> <th> Tournament</th>
</tr>
</thead>
<tbody>
<?php
$matches = find_matches_by_member($_SESSION['id']);
if(mysqli_num_rows($matches)>0){
  while($data = mysqli_fetch_assoc($matches)){
    $row = "<tr>"."<td>".get_full_name($data['member1_id'])."</td>"."<td>".get_full_name($data['member2_id'])."</td>";
    if($data['outcome']==0){
      $row .= "<td>"."TBD"."</td>";
    }
    else if($data['outcome']==1){
      $row .= "<td>".get_full_name($data['member1_id'])." Won"."</td>";
    }
    else if($data['outcome']==2){
      $row .= "<td>".get_full_name($data['member2_id'])." Won"."</td>";
    }
    else if($data['outcome']==3){
      $row .= "<td>"."Draw"."</td>";
    }
    if($data['final']==1){
      $row .= "<td>"."Final"."</td>";
    }
    else{
      $row .= "<td>"."Group Stage"."</td>";
    }
    $row .= "<td>".getTournamentTitle($data['tournament_id'])."</td>";
    $row .="</tr>";
    echo $row;
  }
}

?>
   
   </body>
</html>
<?php include(SHARED_PATH . '/footer.php'); ?>
