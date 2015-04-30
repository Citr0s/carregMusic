<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Tracks</h2>
                <table style="margin:15px;">
                <?php
                  if(isset($_GET['id'])){
                    $id = sanitise(trim($_GET['id']));
                    if(!is_numeric($id)){
                      header("Location: tracks.php");
                      die();
                    }
                    $data = mysqli_query($con, "SELECT tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                          AS artists, tracks.coverPicture, COUNT(trackArtists.trackID) AS artistCount FROM tracks
                          INNER JOIN trackArtists USING (trackID)
                          INNER JOIN artists USING (artistID) WHERE trackID = '$id' 
                          GROUP BY tracks.trackID
                          ORDER BY trackTitle ASC LIMIT 1");

                    echo '<a style="padding:15px;" href="tracks.php">< Back</a>';

                    while($row = mysqli_fetch_array($data)){ 
                      $trackTitle = $row['trackTitle'];
                      $artists = $row['artists']; 
                      $artistCount = $row['artistCount']; 
                      $trackPicture = $row['coverPicture'];

                      echo '<tr><td><img src="css/coverPictures/'. $trackPicture . '" width="250" /></td><td><p class="artistName">'.$artists.' - '.$trackTitle.'</p></td></tr>';
                    }
                  }else{
                    $data = mysqli_query($con, "SELECT concerts.concertName, venues.venueName, countries.countryName
      FROM concerts INNER JOIN venues USING (venueID) INNER JOIN countries USING (countryID)
      ORDER BY concertName ASC";
  $result=mysqli_query($conn, $query);    
  
  while($row = mysqli_fetch_array($result)){ 
           $concertName=$row['concertName']; 
           $venueName=$row['venueName']; 
           $countryName=$row['countryName']; 
    //Display the result of the array 
    echo $concertName . "<br>"; 
    echo $venueName . "<br>";
    echo $countryName . "<br>";
  }");

                    while($row = mysqli_fetch_array($data)){ 
                      $trackTitle = $row['trackTitle'];
                      $artists = $row['artists']; 
                      $artistCount = $row['artistCount']; 
                      $trackPicture = $row['coverPicture'];
                      $trackID = $row['trackID'];

                      echo '<tr><td><a href="?id='.$trackID.'"><img src="css/coverPictures/'. $trackPicture . '" width="150" /></a></td><td><p class="artistName">'.$artists.' - '.$trackTitle.'</p></td></tr>';
                    }
                  }
                ?>
                </table>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>