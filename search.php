<?php 
    require_once 'bootstrap.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
?>
        <style>
          .tipP{
            margin:15px 5px;
          }
          td{
            padding:0px 15px;
          }
        </style>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Search</h2>
                <div class="tipP"><p>Search artists, tracks or venues.</p></div>
                <div class="tipEmpty">
                  <form method="get" action="">
                    <input type="text" id="searchLarge" name="search" value="<?php if($_GET){HtmlText($_GET['search']);} ?>" placeholder="Search for album, artist, concert or venue.">
                    <select name="criteria">
                      <option value="artists">Artists</option>
                      <option value="tracks">Tracks</option>
                      <option value="concerts">Concerts</option>
                      <option value="venues">Venues</option>
                    </select>
                    <button class="loginRegisterButton" style="float:none;">SEARCH</button>
                  </form>
                </div>
                <?php
                  if(isset($_GET['search'])){
                    $search = sanitise(trim($_GET['search']));
                    
                    if(isset($_GET['criteria']) && $_GET['criteria'] === 'tracks'){
                      echo '<div class="tipP"><p>Tracks</p></div>';
                    ?>
                    <div class="tipP">
                        <form method="get" action="">
                          <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>" />
                          <input type="hidden" name="criteria" value="<?php echo $_GET['criteria']; ?>" />
                          <select name="sort" style="margin:15px;">
                            <option value="aa">Artist A-Z</option>
                            <option value="az">Artist Z-A</option>
                            <option value="ta">Track A-Z</option>
                            <option value="tz">Track Z-A</option>
                          </select>
                          <button class="loginRegisterButton" style="float:none;">SORT</button>
                        </form>
                      </div>
                      <table>
                    <?php

                      if(isset($_GET['sort'])){
                        $sort = sanitise(trim($_GET['sort']));
                        switch($sort){
                          case 'aa':
                            $sort = 'artistName ASC';
                            break;
                          case 'az':
                            $sort = 'artistName DESC';
                            break;
                          case 'ta':
                            $sort = 'trackTitle ASC';
                            break;
                          case 'tz':
                            $sort = 'trackTitle DESC';
                            break;
                          default:
                            $sort = 'artistName ASC';
                            break;
                        }
                      }else{
                        $sort = 'artistName ASC';
                      }

                    $data = mysqli_query($con, "SELECT trackID, tracks.trackTitle, GROUP_CONCAT(artists.artistName separator ' and ') 
                                                                    AS artists, tracks.coverPicture, count(trackArtists.trackID) AS artistCount FROM tracks
                                                                    INNER JOIN trackArtists USING (trackID)
                                                                    INNER JOIN artists USING (artistID) 
                                                                    WHERE artists.artistName LIKE '%" . $search . "%'
                                                                    GROUP BY tracks.trackID
                                                                    ORDER BY ".$sort);

                    while($row = mysqli_fetch_array($data)){ 
                      $trackTitle = $row['trackTitle']; 
                      $artists = $row['artists']; 
                      $artistCount = $row['artistCount']; 
                      $trackPicture = $row['coverPicture'];
                      $trackID = $row['trackID'];

                      echo '<tr><td><a href="tracks.php?id='.$trackID.'"><img src="css/coverPictures/'. $trackPicture . '" width="150" /></a></td><td><p class="artistName">'.$artists.' - '.$trackTitle.'</p></td></tr>';
                    }
                    }elseif(isset($_GET['criteria']) && $_GET['criteria'] === 'artists'){

                      echo '</table><div class="tipP"><p>Artists</p></div><table>';

                    if(isset($_GET['search'])){
                    ?>
                    <div class="tipP">
                        <form method="get" action="">
                          <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>" />
                          <input type="hidden" name="criteria" value="<?php echo $_GET['criteria']; ?>" />
                          <select name="sort" style="margin:15px;">
                            <option value="aa">Artist A-Z</option>
                            <option value="az">Artist Z-A</option>
                          </select>
                          <button class="loginRegisterButton" style="float:none;">SORT</button>
                        </form>
                      </div>
                      <table>
                    <?php
                      }

                    if(isset($_GET['sort'])){
                      $sort = sanitise(trim($_GET['sort']));
                      switch($sort){
                        case 'aa':
                          $sort = 'artistName ASC';
                          break;
                        case 'az':
                          $sort = 'artistName DESC';
                          break;
                        default:
                          $sort = 'artistName ASC';
                          break;
                      }
                    }else{
                      $sort = 'artistName ASC';
                    }

                    $data = mysqli_query($con, "SELECT * FROM artists 
                                                WHERE artists.artistName LIKE '%" . $search . "%' ORDER By ".$sort);

                    ?>



                    <?php
                    while($row = mysqli_fetch_array($data)){ 
                      $artistID = $row['artistID'];
                      $artistName = $row['artistName'];
                      $artistHistory = $row['artistHistory']; 
                      $artistPicture = $row['artistPicture'];

                      echo '<tr><td><a href="artists.php?id='.$artistID.'"><img src="css/artistPictures/'. $artistPicture . '" width="150" /></a></td><td><p class="artistName">'.$artistName.'</p></td></tr>';
                    }
                  }elseif(isset($_GET['criteria']) && $_GET['criteria'] === 'concerts'){
                    echo '</table><div class="tipP"><p>Concerts</p></div><table>';

                    if(isset($_GET['search'])){
                    ?>
                    <div class="tipP">
                        <form method="get" action="">
                          <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>" />
                          <input type="hidden" name="criteria" value="<?php echo $_GET['criteria']; ?>" />
                          <select name="sort" style="margin:15px;">
                            <option value="ca">Concert A-Z</option>
                            <option value="cz">Concert Z-A</option>
                            <option value="sf">Sooner First</option>
                            <option value="lf">Later First</option>
                          </select>
                          <button class="loginRegisterButton" style="float:none;">SORT</button>
                        </form>
                      </div>
                      <table>
                    <?php
                      }

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
                                                WHERE concertName LIKE '%" . $search . "%' 
                                                AND concerts.ConcertDate >= CURDATE()
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
                  }elseif(isset($_GET['criteria']) && $_GET['criteria'] === 'venues'){

                    echo '</table><div class="tipP"><p>Venues</p></div><table>';

                    if(isset($_GET['search'])){
                    ?>
                    <div class="tipP">
                        <form method="get" action="">
                          <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>" />
                          <input type="hidden" name="criteria" value="<?php echo $_GET['criteria']; ?>" />
                          <select name="sort" style="margin:15px;">
                            <option value="ca">Venue A-Z</option>
                            <option value="cz">Venue Z-A</option>
                          </select>
                          <button class="loginRegisterButton" style="float:none;">SORT</button>
                        </form>
                      </div>
                      <table>
                    <?php
                      }

                    if(isset($_GET['sort'])){
                      $sort = sanitise(trim($_GET['sort']));
                      switch($sort){
                        case 'ca':
                          $sort = 'venueName ASC';
                          break;
                        case 'cz':
                          $sort = 'venueName DESC';
                          break;
                        default:
                          $sort = 'venueName ASC';
                          break;
                      }
                    }else{
                      $sort = 'venueName ASC';
                    }

                    $data = mysqli_query($con, "SELECT concertID, concerts.concertName, venues.venueName, countries.countryName
                                                FROM concerts 
                                                INNER JOIN venues USING (venueID) 
                                                INNER JOIN countries USING (countryID)
                                                WHERE venueName LIKE '%" . $search . "%' 
                                                AND concerts.ConcertDate >= CURDATE()
                                                ORDER BY ".$sort);
                    
                    while($row = mysqli_fetch_array($data)){ 
                      $concertID = $row['concertID'];
                      $concertName = $row['concertName']; 
                      $venueName = $row['venueName']; 
                      $countryName = $row['countryName'];

                      echo '<tr><td><a href="concerts.php?id='.$concertID.'"><p class="artistName">'.$concertName.' - '.$venueName.' ('.$countryName.')</p></a></td></tr>';
                    }
                  }
                }
                ?>
                </table>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>