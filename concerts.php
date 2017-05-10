<?php 
    require_once 'bootsrap.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
?>
<script src="http://maps.googleapis.com/maps/api/js"></script>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Concerts</h2>
                <?php
                  if(!isset($_GET['id'])){
                ?>
                <form method="get" action="" class="floatLeft">
                  <select name="sort" style="margin:15px;">
                    <option value="ca">Concert A-Z</option>
                    <option value="cz">Concert Z-A</option>
                    <option value="sf">Sooner First</option>
                    <option value="lf">Later First</option>
                  </select>
                  <button class="loginRegisterButton">SORT</button>
                </form>
                <div class="clear"></div>
                <?php
                  }
                ?>
                <table style="margin:15px;">
                <?php
                  if(isset($_GET['id'])){
                    $id = sanitise(trim($_GET['id']));
                    if(!is_numeric($id)){
                      header("Location: tracks.php");
                      die();
                    }
                    $data = mysqli_query($con, "SELECT concertID, concerts.concertName, venues.venueName, venues.venueLongitude, venues.venueLatitude, venues.venueCapacity, countries.countryName
                                                FROM concerts
                                                INNER JOIN venues USING (venueID) 
                                                INNER JOIN countries USING (countryID)
                                                WHERE concertID = $id
                                                ORDER BY concertName ASC LIMIT 1");

                    echo '<a class="backLink" href="concerts.php">< Back</a>';

                    $row = mysqli_fetch_array($data);
                    $concertID = $row['concertID'];
                    $concertName = $row['concertName']; 
                    $venueName = $row['venueName'];
                    $venueLongitude = $row['venueLongitude'];
                    $venueLatitude = $row['venueLatitude'];
                    $venueCapacity = $row['venueCapacity'];
                    $countryName = $row['countryName'];

                    ?>
                    <script>
                      var myCenter = new google.maps.LatLng(<?php echo $venueLatitude; ?>,<?php echo $venueLongitude; ?>);

                      function initialize()
                      {
                      var mapProp = {
                        center:myCenter,
                        zoom:15,
                        mapTypeId:google.maps.MapTypeId.ROADMAP
                        };

                      var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

                      var marker = new google.maps.Marker({
                        position:myCenter,
                        });

                      marker.setMap(map);
                      }

                      google.maps.event.addDomListener(window, 'load', initialize);
                    </script>
                    <?php

                    echo '<tr><td><p class="artistName">'.$concertName.' - '.$venueName.' ('.$countryName.')</p></td></tr>';
                    echo '<tr><td><p class="artistName">Capacity: '.$venueCapacity.'</p></td></tr>';
                    echo '<tr><td><div id="googleMap" style="width:500px;height:380px;"></div></td></tr>';

                    $count = 0;
                    $data = mysqli_query($con, "SELECT * FROM artists INNER JOIN concertartists USING (artistID)
                                                INNER JOIN concerts USING (concertID)
                                                WHERE concertName LIKE '%" . $concertName . "%' 
                                                ORDER By artistName ASC");    

                    echo '</table><table style="margin:15px;"><tr><td><p>Artists apearing at this concert: </p></td></tr>';
                    
                    while($row = mysqli_fetch_array($data)){ 
                      $artistName = $row['artistName'];
                      $artistHistory = $row['artistHistory'];
                      $artistPicture = $row['artistPicture'];
                      $artistID = $row['artistID'];
                      $count++;

                      echo '<tr><td><a href="artists.php?id='.$artistID.'"><img src="css/artistPictures/'. $artistPicture . '" width="250" /></a></td><td><p><a href="artists.php?id='.$artistID.'">'.$artistName.'</a></p></td></tr>';
                    }

                    if($count === 0){
                      echo '<tr><td><p class="usernameC">None</p></td></tr>';
                    }

                  }else{

                    if(isset($_GET['sort'])){
                      $sort = sanitise(trim($_GET['sort']));
                      switch($sort){
                        case 'ca':
                          $extraArgs = '';
                          $sort = 'concertName ASC';
                          break;
                        case 'cz':
                          $extraArgs = '';
                          $sort = 'concertName DESC';
                          break;
                        case 'sf':
                          $extraArgs = 'WHERE concerts.concertDate > CURDATE()';
                          $sort = 'DATE ASC';
                          break;
                        case 'lf':
                          $extraArgs = 'WHERE concerts.concertDate > CURDATE()';
                          $sort = 'DATE DESC';
                          break;
                        default:
                          $extraArgs = '';
                          $sort = 'concertName ASC';
                          break;
                      }
                    }else{
                      $extraArgs = '';
                      $sort = 'concertName ASC';
                    }

                    $data = mysqli_query($con, "SELECT concertID, concerts.concertName, venues.venueName, countries.countryName, concerts.concertDate, UNIX_TIMESTAMP(concerts.concertDate) AS DATE
                                                FROM concerts 
                                                INNER JOIN venues USING (venueID) 
                                                INNER JOIN countries USING (countryID)
                                                ".$extraArgs."
                                                ORDER BY ".$sort);   
  
                    while($row = mysqli_fetch_array($data)){
                      $concertID = $row['concertID'];
                      $concertName = $row['concertName']; 
                      $venueName = $row['venueName']; 
                      $countryName = $row['countryName'];
                      $concertDate = floor((strtotime($row['concertDate']) - time()) / 86400);

                      echo '<tr><td><a href="?id='.$concertID.'"><p class="artistName">'.$concertName.' - '.$venueName.' ('.$countryName.') (';
                      if($concertDate == 1){
                        echo $concertDate.' day';
                      }
                      if($concertDate < 0){
                        echo abs($concertDate).' days ago';
                      }else{
                        echo $concertDate.' days left';
                      }
                      echo ')</p></a></td></tr>';
                    }
                  }
                ?>
                </table>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>