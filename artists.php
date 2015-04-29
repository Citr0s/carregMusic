<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    if(!loggedIn()){
      header("Location: index.php");
    }

    $con = mysqli_connect($addr, $user, $password, $db);

    $data = mysqli_query($con, "SELECT userNickname, userEmail, countries.countryName, genres.genreName, countryID, genreID 
                                FROM users INNER JOIN countries USING (countryID) INNER JOIN genres USING (genreID) 
                                WHERE username = '$username' LIMIT 1");

    while($row = mysqli_fetch_array($data)){
      $nickname = $row['userNickname'];
      $email = $row['userEmail'];
      $countryID = $row['countryID'];
      $country = $row['countryName'];
      $genreID = $row['genreID'];
      $genre = $row['genreName'];
    }

?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Artists</h2>
                <?php
                  $data = mysqli_query($con, "SELECT tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' and ') 
                          AS artists, tracks.trackPicture, COUNT(trackArtists.trackID) AS artistCount FROM tracks
                          INNER JOIN trackArtists USING (trackID)
                          INNER JOIN artists USING (artistID) 
                          GROUP BY tracks.trackID
                          ORDER BY trackTitle ASC");
                
                  while($row = mysqli_fetch_array($data)){ 
                    $trackTitle = $row['trackTitle'];
                    $artists = $row['artists']; 
                    $artistCount = $row['artistCount']; 
                    $trackPicture = $row['trackPicture'];

                    echo $trackTitle . "<br>"; 
                    echo $artists . "<br>";
                    echo $trackPicture . "<br>";
                  }
                ?>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>