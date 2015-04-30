<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
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

                    echo '<a style="padding:15px;" href="artists.php">< Back</a>';

                    while($row = mysqli_fetch_array($data)){ 
                      $artistName = $row['artistName'];
                      $artistHistory = $row['artistHistory']; 
                      $artistPicture = $row['artistPicture'];

                      echo '<tr><td><img src="css/artistPictures/'. $artistPicture . '" width="250" /></td><td><p class="artistName">'.$artistName.'</p></td></tr>';
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

                      
                      echo ' <div id="topDiv" class="topDiv">
                          <img src="css/artistPictures/'. $artistPicture . '  " "class="imageToHover  />
                          <div id="innerDiv" class="innerDiv">
                          <a href="?id='.$artistID.'" class="artistHoverLinks">'.$artistName.'</a>
                          </div>
                          <p class="artistName">'.$artistName.'</p>
                          </div>';
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