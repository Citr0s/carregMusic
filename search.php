<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Search</h2>
                <table style="margin:15px;">
                <?php
                  if(isset($_GET['id'])){
                    $id = sanitise(trim($_GET['id']));
                    if(!is_numeric($id)){
                      header("Location: search.php");
                      die();
                    }
                      $data = mysqli_query($con, "SELECT tracks.trackTitle, GROUP_CONCAT(artists.artistName separator ' and ') 
                          AS artists, tracks.coverPicture, count(trackArtists.trackID) AS artistCount FROM tracks
                          INNER JOIN trackArtists USING (trackID)
                          INNER JOIN artists USING (artistID) 
                          WHERE artists.artistName LIKE '%" . $id . "%'
                          GROUP BY tracks.trackID
                          ORDER BY artistName ASC");    
                      
                      while($row = mysqli_fetch_array($data)){ 
                        $trackTitle = $row['trackTitle']; 
                        $artists = $row['artists']; 
                        $artistCount = $row['artistCount']; 
                        $trackPicture = $row['coverPicture'];

                        echo $trackTitle . "<br>"; 
                        echo $artists . "<br>";
                        echo $trackPicture . "<br>";
                  }
                }else{
                  echo '<div class="tipP"><p>Search artists, tracks or venues.</p></div>';
                  echo '<tr><td><form method="get" action=""><input type="text" id="searchLarge" name="search" placeholder="album, artist, concert"></form></td></tr>';
                }
                ?>
                </table>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>