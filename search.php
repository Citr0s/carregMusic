<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Search</h2>
                <table style="margin:15px;">
                  <div class="tipP"><p>Search artists, tracks or venues.</p></div>
                  <form method="get" action=""><input type="text" id="searchLarge" name="search" value="<?php if($_GET){HtmlText($_GET['search']);} ?>" placeholder="album, artist, concert"></form>
                <?php
                  if(isset($_GET['search'])){
                    $search = sanitise(trim($_GET['search']));
                      $data = mysqli_query($con, "SELECT trackID, tracks.trackTitle, GROUP_CONCAT(artists.artistName separator ' and ') 
                          AS artists, tracks.coverPicture, count(trackArtists.trackID) AS artistCount FROM tracks
                          INNER JOIN trackArtists USING (trackID)
                          INNER JOIN artists USING (artistID) 
                          WHERE artists.artistName LIKE '%" . $search . "%'
                          GROUP BY tracks.trackID
                          ORDER BY artistName ASC");
                      
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