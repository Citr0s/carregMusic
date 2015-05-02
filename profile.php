<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    if(!loggedIn()){
      header("Location: index.php");
    }

    $con = mysqli_connect($addr, $user, $password, $db);

    $data = mysqli_query($con, "SELECT userNickname, userEmail, countries.countryName, genres.genreName, countryID, genreID FROM users INNER JOIN countries USING (countryID) INNER JOIN genres USING (genreID) WHERE username = '$username' LIMIT 1");

    while($row = mysqli_fetch_array($data)){
      $nickname = $row['userNickname'];
      $email = $row['userEmail'];
      $countryID = $row['countryID'];
      $country = $row['countryName'];
      $genreID = $row['genreID'];
      $genre = $row['genreName'];
    }

    $errorMessages = array();

    if($_POST){
      if(isset($_POST['password']) || isset($_POST['passwordCheck'])){
        $expected = array('password', 'passwordCheck');
        $required = array('password', 'passwordCheck');

        foreach($expected as $field) {
          $fieldValue = trim($_POST[$field]);
          if(empty($fieldValue)){
            if(isRequired($field, $required)) {
                $errorMessages[$field] = ucfirst($field).' is a required field';
            }
          }else{
            if($msg = validateFormField($fieldValue, $field)){
                $errorMessages[$field] = $msg;
            }
          }
        }

        if(!$errorMessages){
            
          $con = mysqli_connect($addr, $user, $password, $db);

          $password = sanitise(trim($_POST['password']));
          $passwordCheck = sanitise(trim($_POST['passwordCheck']));

          if($password !== $passwordCheck){
            $errorMessages['form'] = 'Passwords don\'t match';
          }else{
            mysqli_query($con, "UPDATE users SET userPassword = '$password' WHERE username = '$username'") or die("Query adding new user failed:" . mysql_error()); 
            header("Location: profile.php?".$username."&success");
          }
        }
      }else{
        $expected = array('nickname', 'email', 'country', 'genre');
        $required = array('nickname', 'email', 'country', 'genre');

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

        if(!$errorMessages){
            
          $con = mysqli_connect($addr, $user, $password, $db);

          $nickname = sanitise(trim($_POST['nickname']));
          $email = sanitise(trim($_POST['email']));
          $country = sanitise(trim($_POST['country']));
          $genre = sanitise(trim($_POST['genre']));

          mysqli_query($con, "UPDATE users SET userNickname = '$nickname', userEmail = '$email', countryID = '$country', genreID = '$genre' WHERE username = '$username'") or die("Query adding new user failed:" . mysql_error()); 
          header("Location: profile.php?".$username."&success");
        }
      }
    }
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2"><?php echo $username; ?></h2>
                <?php
                  if(isset($_GET['delC'])){
                    $id = sanitise(trim($_GET['delC']));
                    if(!is_numeric($id)){
                      header("Location: index.php");
                      die();
                    }

                    $data = mysqli_query($con, "SELECT * FROM `usercomments` WHERE username = '$username' && trackID = $id LIMIT 1") or header("Location: index.php");
                    
                    $row = mysqli_fetch_array($data);

                    if($row['username'] != $username){
                      header("Location: index.php");
                      die();
                    }else{
                      mysqli_query($con, "DELETE FROM `usercomments` WHERE trackID = $id AND username = '$username'");
                      header("Location: profile.php?".$username."&activity&successD");
                    }
                  }
                  if(isset($_GET['delR'])){
                    $id = sanitise(trim($_GET['delR']));
                    if(!is_numeric($id)){
                      header("Location: index.php");
                      die();
                    }

                    $data = mysqli_query($con, "SELECT * FROM `userratings` WHERE username = '$username' && trackID = $id LIMIT 1") or header("Location: index.php");
                    
                    $row = mysqli_fetch_array($data);

                    if($row['username'] != $username){
                      header("Location: index.php");
                      die();
                    }else{
                      mysqli_query($con, "DELETE FROM `userratings` WHERE trackID = $id AND username = '$username'");
                      header("Location: profile.php?".$username."&activity&successD");
                    }
                  }
                  if($_POST){
                    echo '<div class="tipE">';
                    foreach($errorMessages as $error){
                      echo '<p>'.$error.'</p>';
                    }
                    echo '</div>';
                  }elseif(isset($_GET['success'])){
                    echo '<div class="tipS">';
                      echo '<p>Your details have been saved successfully.</p>';
                    echo '</div>';
                  }elseif(isset($_GET['successD'])){
                    echo '<div class="tipS">';
                      echo '<p>Record deleted successfully.</p>';
                    echo '</div>';
                  }else{
                    echo '<div class="tipP"><p>Welcome to your profile. Here you can edit or close your account.</p></div>';
                  }
                ?>
                <div class="profileMenu">
                  <ul>
                    <li><a href="?<?php echo $username; ?>&activity" <?php if(isset($_GET['activity']) || (!isset($_GET['edit'])) && !isset($_GET['close'])){ echo 'class="selected"';}?>>ACTIVITY</a></li>
                    <li><a href="?<?php echo $username; ?>&edit" <?php if(isset($_GET['edit'])){ echo 'class="selected"';}?>>EDIT</a></li>
                    <li><a href="?<?php echo $username; ?>&close" <?php if(isset($_GET['close'])){ echo 'class="selected"';}?>>CLOSE</a></li>
                  </ul>
                </div>
                <?php if(isset($_GET['activity'])){ ?>
                  
                  <table><tr><td><p>Your Ratings</p></td></tr>
                <?php
                  $anyComments = false;
                  $data = mysqli_query($con, "SELECT userratings.username, userratings.trackID, userratings.userRating, tracks.chartPosition, tracks.releaseDate, tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                                              AS artists, tracks.coverPicture FROM tracks
                                              INNER JOIN userratings USING (trackID)
                                              INNER JOIN trackArtists USING (trackID)
                                              INNER JOIN artists USING (artistID) WHERE username = 'test2'
                                              GROUP BY tracks.trackID");

                    while($row = mysqli_fetch_array($data)){ 
                      $commentUsername = $row['username'];
                      $userRating = $row['userRating'];
                      $trackTitle = $row['trackTitle'];
                      $trackArtist = $row['artists'];
                      $coverPicture = $row['coverPicture'];
                      $trackID = $row['trackID'];
                      $anyComments = true;

                      echo '</table><div class="tipC"><div class="floatRight" style="margin:5px;"><a href="?delR='.$trackID.'">[x]</a></div><p><A href="tracks.php?id='.$trackID.'"><img src="css/coverPictures/'.$coverPicture.'" width="25" /></a> '.$userRating.' - <span class="usernameC">'.$trackArtist.' - '.$trackTitle.'</span></p></div><table>';
                    }

                    if(!$anyComments){
                      echo '</table><div class="tipC class"><p><span class="usernameC">No ratings found.</span></p></div><table>';
                    }
                ?>                    
                  <table><tr><td><p>Your Comments</p></td></tr>
                <?php
                  $anyComments = false;
                  $data = mysqli_query($con, "SELECT usercomments.username, usercomments.trackID, usercomments.userCommentVal, tracks.chartPosition, tracks.releaseDate, tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                                              AS artists, tracks.coverPicture FROM tracks
                                              INNER JOIN usercomments USING (trackID)
                                              INNER JOIN trackArtists USING (trackID)
                                              INNER JOIN artists USING (artistID) WHERE username = 'test2'
                                              GROUP BY tracks.trackID");

                    while($row = mysqli_fetch_array($data)){ 
                      $commentUsername = $row['username'];
                      $userCommentVal = $row['userCommentVal'];
                      $trackTitle = $row['trackTitle'];
                      $trackArtist = $row['artists'];
                      $coverPicture = $row['coverPicture'];
                      $trackID = $row['trackID'];
                      $anyComments = true;

                      echo '</table><div class="tipC"><div class="floatRight" style="margin:5px;"><a href="?delC='.$trackID.'">[x]</a></div><p><A href="tracks.php?id='.$trackID.'"><img src="css/coverPictures/'.$coverPicture.'" width="25" /></a> '.$userCommentVal.' - <span class="usernameC">'.$trackArtist.' - '.$trackTitle.'</span></p></div><table>';
                    }

                    if(!$anyComments){
                      echo '</table><div class="tipC class"><p><span class="usernameC">No comments found.</span></p></div><table>';
                    }
                }elseif(isset($_GET['edit'])){ ?>
                <form class="loginForm" action="#" method="post">
                   <table>
                        <th colspan="2" align="left">Update Your Information</th>
                       <tr>
                           <td>Nickname:</td><td><input type="text" name="nickname" value="<?php echo $nickname; ?>" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input type="text" name="email" value="<?php echo $email; ?>" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Country of Origin:</td><td class="tdR"><select name="country" class="country"><option value="<?php echo $countryID; ?>"><?php echo $country; ?></option><?php generateCountryList(); ?></select></td>
                        </tr>
                        <tr>
                           <td>Favourite Genre:</td><td class="tdR"><select name="genre" class="genre"><option value="<?php echo $genreID; ?>"><?php echo $genre; ?></option><?php generateGenreList(); ?></select></td>
                        </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">SAVE</button></td>
                       </tr>
                   </table>
                </form>
                <form class="loginForm" action="#" method="post">
                   <table>
                        <th colspan="2" align="left">Change Your Password</th>

                        <tr>
                           <td>Password:</td><td><input id="Password1" type="password" name="password" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Password Again:</td><td><input id="PasswordCheck" type="password" name="passwordCheck" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">SAVE</button></td>
                       </tr>
                   </table>
                </form>
                <?php } ?>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>