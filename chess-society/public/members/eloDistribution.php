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
google.charts.load("current", {packages:["corechart"]});
      </script>
   </head>
   
   <body>
     <?php
     
    $members = find_all_members();
    if(mysqli_num_rows($members)>0){
      while($row = mysqli_fetch_assoc($members)){
        $elos[$row['fname']." ".$row['lname']]=$row['elo'];
      }
    }
    mysqli_free_result($members);


     ?>
      <div id = "container" >
      </div>
      <script language = "JavaScript">
         function drawChart() {
          var data = google.visualization.arrayToDataTable([
    ['Name', 'Elo']<?php
      foreach($elos as $key=>$value){
        echo ",['" . $key . "'," . $elos[$key] . "]";
      }
      ?>
         
                      

  
  ]);
        
          
     

      var options = {
        title:'Elo Distribution Of Members',
        height:800,
     
        hAxis: {
          title: 'Elo',
          
        
          
          
        },
        vAxis: {
          title: 'Players' ,
          minValue:0,
          
        
     
              
        }
      };
      
          
      var chart = new google.visualization.Histogram(document.getElementById('container'));
            chart.draw(data, options);
            
         }
         google.charts.setOnLoadCallback(drawChart);
      </script>
   </body>
</html>
<?php include(SHARED_PATH . '/footer.php'); ?>
