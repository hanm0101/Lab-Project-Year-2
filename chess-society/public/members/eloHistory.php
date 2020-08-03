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
     <?php
   
    
 $membersElos = find_elo_history($_SESSION['id']);
 $history= array();
 while($row = mysqli_fetch_assoc($membersElos)){
   $history[getTournamentTitle($row['tournament_id'])] = $row['elo_after'];
 }
   

?>

     
      <div id = "container" >
      </div>
      <script language = "JavaScript">
         function drawChart() {
          
          var data = google.visualization.arrayToDataTable([
    ['Tournament', 'Elo']
    ,['Joined Society', 100 ]<?php
      foreach($history as $title=>$elo){
        echo ",['" . $title . "'," . $elo . "]";
      }
      ?>
    
  
  ]);

      var options = {
        title:'Rating History',
        height:800,
        lineWidth:5,
        pointSize:10,
        hAxis: {
          title: 'Tournaments',
          
          
          
          
        },
        vAxis: {
          title: 'Elo' ,
        
        }
      };
      
          
            var chart = new google.visualization.LineChart(document.getElementById('container'));
            chart.draw(data, options);
            
         }
         google.charts.setOnLoadCallback(drawChart);
      </script>
   </body>
</html>
<?php include(SHARED_PATH . '/footer.php'); ?>
