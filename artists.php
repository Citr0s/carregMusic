<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    $con = mysqli_connect($addr, $user, $password, $db);
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Artists</h2>
                <div class="artistContainer">
                <img src="#" atl="alt tag">
                  <div class="artistHover">
                    <p>Text Hover</p>
                  </div>
                </div>
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
                    $data = mysqli_query($con, "SELECT artistID, artistName, artistHistory, artistPicture FROM artists ORDER BY artistName ASC");

                    while($row = mysqli_fetch_array($data)){ 
                      $artistName = $row['artistName'];
                      $artistHistory = $row['artistHistory']; 
                      $artistPicture = $row['artistPicture'];
                      $artistID = $row['artistID'];

                      echo '<tr><td><a href="?id='.$artistID.'"><img src="css/artistPictures/'. $artistPicture . '" width="150" /></a></td><td><p class="artistName">'.$artistName.'</p></td></tr>';
                    }
                  }
                ?>
                </table>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>