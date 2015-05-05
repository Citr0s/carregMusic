<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Artists</h2>
                <table style="margin:15px;">
                <?php
                  if(isset($_GET['id'])){
                    $id = sanitise(trim($_GET['id']));
                    if(!is_numeric($id)){
                      header("Location: artists.php");
                      die();
                    }
                    $data = mysqli_query($con, "SELECT artistID, artistName, artistHistory, artistPicture FROM artists WHERE artistID = '$id' 
                                                ORDER BY artistName ASC LIMIT 1");

                    echo '<a class="backLink" href="artists.php">< Back</a>';
                    $row = mysqli_fetch_array($data);
                    $artistName = $row['artistName'];
                    $artistHistory = $row['artistHistory']; 
                    $artistPicture = $row['artistPicture'];

                    echo '<tr><td><img src="css/artistPictures/'. $artistPicture . '" width="250" /></td><td><p class="artistName">'.$artistName.'</p><p>'.$artistHistory.'</p></td></tr>';

                    $count = 0;
                    $data = mysqli_query($con, "SELECT concerts.concertID, concerts.concertName, venues.venueName, countries.countryName
                                                FROM concerts INNER JOIN venues USING (venueID) INNER JOIN countries USING (countryID)
                                                INNER JOIN concertartists USING(concertID) INNER JOIN artists USING (artistID)
                                                WHERE artistName LIKE '%" . $artistName . "%' AND concerts.ConcertDate >= CURDATE()
                                                ORDER BY concertName ASC");
                      
                    while($row = mysqli_fetch_array($data)){ 
                             $concertName = $row['concertName']; 
                             $venueName = $row['venueName']; 
                             $countryName = $row['countryName'];
                             $councertID = $row['concertID'];
                             $count++;
                    }

                    echo '<tr><td></td><td><p>'.$artistName.'\'s Upcoming Concerts:</p><td>';
                    if($count > 0){
                      echo '<p><A href="concerts.php?id='.$councertID.'">'.$concertName.' - '.$venueName.' ('.$countryName.')</a></p></td></tr>';
                    }else{
                      echo '<p class="usernameC">Currently not on tour.</p></td></tr>';
                    }
                  }else{
                    $p = isset($_GET['p']) ? (int)$_GET['p'] : 1; //check if page set, if not set page tp 1
                    $perP = 10; //records per page

                    $start = ($p > 1) ? ($p * $perP) - $perP : 0; //start value for getting records from db

                    $data = mysqli_query($con, "SELECT COUNT(*) AS num FROM artists");

                    $row = mysqli_fetch_array($data);
                    $count = $row['num'];


                    $data = mysqli_query($con, "SELECT artistID, artistName, artistHistory, artistPicture FROM artists ORDER BY artistName ASC LIMIT ".$start.", ".$perP);

                    while($row = mysqli_fetch_array($data)){ 
                      $artistName = $row['artistName'];
                      $artistHistory = $row['artistHistory']; 
                      $artistPicture = $row['artistPicture'];
                      $artistID = $row['artistID'];

                      
                      echo ' <div class="topDiv">
                          <img src="css/artistPictures/'. $artistPicture . '  " "class="imageToHover  />
                          <div class="innerDiv">
                          <a href="?id='.$artistID.'" class="artistHoverLinks">'.$artistName.'</a>
                          </div>
                          </div>';
                    }

                    
                    $ps = ceil($count / $perP);
                    echo '<tr><td>';
                    for($i = 1; $i <= $ps; $i++){
                      echo '<div class="pagination"><a href="?p='.$i.'"';
                      if($p === $i){
                        echo 'class="selectedP"'; 
                      }
                      echo '>'.$i.'</a></div>';
                    }
                    echo '</td></tr>';
                  }
                ?>
                </table>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>