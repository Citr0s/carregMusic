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

                    $anyRatings = false;
                    $userRatings = 0;
                    $data = mysqli_query($con, "SELECT *, COUNT(*) AS ratings FROM userratings WHERE trackID = $id");

                    while($row = mysqli_fetch_array($data)){ 
                      $ratingsUsername = $row['username'];
                      $userRatings += $row['userRating'];
                      $anyRatings = true;
                      $ratings = $row['ratings'];
                    }
                    if(!$anyRatings || $ratings == 0){
                      echo '<tr><td><p>Rating: - / 5</p></td></tr>';
                    }else{
                      $AvrRating = round($userRatings / $ratings, 1);
                      echo '<tr><td><p>Rating: '.$AvrRating.' / 5</p></td></tr>';
                    }

                    echo '<tr><td><p>Comments</p></td></tr>';

                    $anyComments = false;
                    $data = mysqli_query($con, "SELECT * FROM usercomments WHERE trackID = $id");

                    while($row = mysqli_fetch_array($data)){ 
                      $commentUsername = $row['username'];
                      $userCommentVal = $row['userCommentVal'];
                      $anyComments = true;

                      echo '</table><div class="tipC"><p>'.$userCommentVal.' - <span class="usernameC">'.$commentUsername.'</span></p></div><table>';
                    }

                    if(!$anyComments){
                      echo '</table><div class="tipC"><p><span class="usernameC">No comments found.</span></p></div><table>';
                    }

                  }else{
                    $p = isset($_GET['p']) ? (int)$_GET['p'] : 1; //check if page set, if not set page tp 1
                    $perP = 10; //records per page

                    $start = ($p > 1) ? ($p * $perP) - $perP : 0; //start value for getting records from db

                    $data = mysqli_query($con, "SELECT COUNT(*) AS num FROM tracks");

                    $row = mysqli_fetch_array($data);
                    $count = $row['num'];

                    $data = mysqli_query($con, "SELECT trackID, tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                          AS artists, tracks.coverPicture, COUNT(trackArtists.trackID) AS artistCount FROM tracks
                          INNER JOIN trackArtists USING (trackID)
                          INNER JOIN artists USING (artistID) 
                          GROUP BY tracks.trackID
                          ORDER BY trackTitle ASC LIMIT ".$start.", ".$perP);

                    while($row = mysqli_fetch_array($data)){ 
                      $trackTitle = $row['trackTitle'];
                      $artists = $row['artists']; 
                      $artistCount = $row['artistCount'];
                      $trackPicture = $row['coverPicture'];
                      $trackID = $row['trackID'];

                      echo '<tr><td><a href="?id='.$trackID.'"><img src="css/coverPictures/'. $trackPicture . '" width="150" /></a></td><td><p class="artistName">'.$artists.' - '.$trackTitle.'</p></td></tr>';
                    }

                    $ps = ceil($count / $perP);
                    echo '<tr><td>';
                    for($i = 1; $i <= $ps; $i++){
                      echo '<div class="pagination"><a href="?p='.$i.'"';
                      if($p === $i){
                        echo 'class="selected"'; 
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