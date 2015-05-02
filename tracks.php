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
                    if(isset($_POST['comment'])){
                      $errorMessages = [];

                      $expected = array('comment');
                      $required = array('comment');

                      foreach($expected as $field) {
                        $fieldValue = trim($_POST[$field]);
                        if(empty($fieldValue)){
                          if(isRequired($field, $required)) {
                              $errorMessages[$field] = ucfirst($field).' is a required field';
                          }
                        }else{
                          if($msg = validateFormField($fieldValue, $field)) {
                              $errorMessages[$field] = $msg;
                          }
                        }
                      }

                      $alreadyCommented = false;

                      $data = mysqli_query($con, "SELECT username FROM usercomments WHERE username = '$username' AND trackID = $id");

                      while($row = mysqli_fetch_array($data)){
                        $alreadyCommented = true;
                      }

                      if($alreadyCommented){
                        $errorMessages['form'] = 'You can only comment once.';
                      }

                      if(!$errorMessages){
                        $con = mysqli_connect($addr, $user, $password, $db);
                        $comment = sanitise(trim($_POST['comment']));

                        mysqli_query($con, "INSERT INTO usercomments (username, trackID, userCommentVal) VALUES('$username', '$id', '$comment')") 
                        or die("Query adding new comment failed:" . mysqli_error($con)); 

                        echo "Comment added successfully. Please wait for redirection.";
                        header("Location: tracks.php?id=".$id."&successC");                          

                      }else{
                        echo '<div class="tipE">';
                        foreach($errorMessages as $error){
                          echo '<p>'.$error.'</p>';
                        }
                        echo '</div>';
                      }
                    }

                    if(isset($_POST['rating'])){
                      $errorMessages = [];

                      $expected = array('rating');
                      $required = array('rating');

                      foreach($expected as $field) {
                        $fieldValue = trim($_POST[$field]);
                        if(empty($fieldValue)){
                          if(isRequired($field, $required)) {
                              $errorMessages[$field] = ucfirst($field).' is a required field';
                          }
                        }else{
                          if($msg = validateFormField($fieldValue, $field)) {
                              $errorMessages[$field] = $msg;
                          }
                        }
                      }

                      $alreadyRated = false;

                      $data = mysqli_query($con, "SELECT username FROM userratings WHERE username = '$username' AND trackID = $id");

                      while($row = mysqli_fetch_array($data)){
                        $alreadyRated = true;
                      }

                      if($alreadyRated){
                        $errorMessages['form'] = 'You can only rate once.';
                      }

                      if(!$errorMessages){
                        $con = mysqli_connect($addr, $user, $password, $db);
                        $rating = sanitise(trim($_POST['rating']));

                        if(!is_numeric($rating)){
                          header("Location: tracks.php?id=".$id);
                          die();
                        }

                        mysqli_query($con, "INSERT INTO userratings (username, trackID, userRating) VALUES('$username', '$id', '$rating')") 
                        or die("Query adding new comment failed:" . mysqli_error($con)); 

                        echo "Rating added successfully. Please wait for redirection.";
                        header("Location: tracks.php?id=".$id."&successR");                          

                      }else{
                        echo '<div class="tipE">';
                        foreach($errorMessages as $error){
                          echo '<p>'.$error.'</p>';
                        }
                        echo '</div>';
                      }
                    }

                    if(isset($_GET['successC'])){
                      echo '<div class="tipS">';
                      echo '<p>Your comment has been added successfully.</p>';
                      echo '</div>';
                    }
                    if(isset($_GET['successR'])){
                      echo '<div class="tipS">';
                      echo '<p>Your rating has been added successfully.</p>';
                      echo '</div>';
                    }

                    $data = mysqli_query($con, "SELECT genres.genreName, tracks.chartPosition, tracks.releaseDate, tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                          AS artists, tracks.coverPicture, COUNT(trackArtists.trackID) AS artistCount FROM tracks
                          INNER JOIN genres USING (genreID)
                          INNER JOIN trackArtists USING (trackID)
                          INNER JOIN artists USING (artistID) WHERE trackID = '$id' 
                          GROUP BY tracks.trackID
                          ORDER BY trackTitle ASC LIMIT 1");

                    echo '<a href="tracks.php" class="backLink">< Back</a>';

                    while($row = mysqli_fetch_array($data)){ 
                      $trackTitle = $row['trackTitle'];
                      $trackReleaseDate = $row['releaseDate'];
                      $trackChartPosition = $row['chartPosition'];
                      $genre = $row['genreName'];
                      $trackTitle = $row['trackTitle'];
                      $artists = $row['artists']; 
                      $artistCount = $row['artistCount']; 
                      $trackPicture = $row['coverPicture'];


                      echo '<tr><td><img src="css/coverPictures/'. $trackPicture . '" width="250" /></td><td><p class="artistName">'.$artists.' - '.$trackTitle.'</p>
                      <p><span class="trackT">Release Date:</span> '.$trackReleaseDate.'</p>
                      <p><span class="trackT">Genre:</span> '.$genre.'</p>
                      <p><span class="trackT">Highest Chart Position:</span> '.$trackChartPosition.'</p></td></tr>';
                    }

                    echo '<tr><td><p>Rating</p></td></tr>';

                    $anyRatings = false;
                    $data = mysqli_query($con, "SELECT *, COUNT(*) AS ratings, SUM(userRating) AS userRatings FROM userratings WHERE trackID = $id");

                    while($row = mysqli_fetch_array($data)){ 
                      $ratingsUsername = $row['username'];
                      $userRatings = $row['userRatings'];
                      $anyRatings = true;
                      $ratings = $row['ratings'];
                    }
                    if(!$anyRatings || $ratings == 0){
                      echo '<tr><td><p class="rating">-</p></td></tr>';
                    }else{
                      $AvrRating = round($userRatings / $ratings, 1);
                      echo '<tr><td><p class="rating">'.$AvrRating.'<span class="ratingOutOf">/5</span></p></td></tr>';
                    }

                    if(loggedIn()){
                      $alreadyRated = false;

                      $data = mysqli_query($con, "SELECT username FROM userratings WHERE username = '$username' AND trackID = $id");

                      while($row = mysqli_fetch_array($data)){
                        $alreadyRated = true;
                      }

                      if(!$alreadyRated){
                        echo '<tr><td><form action="#" method="post"><select name="rating">';
                        for($i = 1; $i <= 5; $i++){
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        echo '</select></td><td><button class="loginRegisterButton">RATE</button></form> </td></tr>';
                      }
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
                      echo '</table><div class="tipC class"><p><span class="usernameC">No comments found.</span></p></div><table>';
                    }

                    $alreadyCommented = false;

                    if(loggedIn()){

                      $data = mysqli_query($con, "SELECT username FROM usercomments WHERE username = '$username' AND trackID = $id");

                      while($row = mysqli_fetch_array($data)){
                        $alreadyCommented = true;
                      }

                      if(!$alreadyCommented){
                      ?>
                      <form class="loginForm" action="#" method="post">
                         <table class="loginForm">
                              <tr>
                                 <td>Comment:</td>
                             </tr>
                             <tr>
                               <td><textarea name="comment" id="commentTxtAra" cols="50" rows="5" placeholder="Your comment"><?php if($_POST){HtmlText($_POST['comment']);} ?></textarea></td>
                             </tr>
                             <tr>
                                 <td><button class="loginRegisterButton">COMMENT</button></td>
                             </tr>
                         </table>
                      </form>
                      <?php
                      }
                    }else{
                      echo '</table><div class="tipC class"><p><span class="usernameC"><a href="login.php">Login</a> to add comments.</span></p></div><table>';
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