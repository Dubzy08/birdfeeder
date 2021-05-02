<!DOCTYPE html>

<?php
   define('BASE_DIR', dirname(__FILE__));
   require_once(BASE_DIR.'/config.php');
   $config = array();
   
   function getImgWidth() {
      global $config;
      if($config['vector_preview'])
         return 'style="width:' . $config['width'] . 'px;"';
      else
         return '';
   }
   
   function getLoadClass() {
      global $config;
      if(array_key_exists('fullscreen', $config) && $config['fullscreen'] == 1)
         return 'class="fullscreen" ';
      else
         return '';
   }

   $streamButton = "MJPEG-Stream";
   $mjpegmode = 0;
   if(isset($_COOKIE["stream_mode"])) {
      if($_COOKIE["stream_mode"] == "MJPEG-Stream") {
         $streamButton = "Default-Stream";
         $mjpegmode = 1;
      }
   }
   $config = readConfig($config, CONFIG_FILE1);
   $config = readConfig($config, CONFIG_FILE2);
   $video_fps = $config['video_fps'];
   $divider = $config['divider'];
   $user = getUser();
   writeLog("Logged in user:" . $user . ":");
   $userLevel =  getUserLevel($user);
   writeLog("UserLevel " . $userLevel);
  ?>

<html>
    <head>
        <title>Smart Bird Feeder</title>
        <!-- <link rel="stylesheet" href="css/style_minified.css" /> --> <!-- this is for centering the video -->
        <script src="js/script.js"></script> <!-- this script is used for the live video feed -->
        <style>
            .img {
                border: 4px solid #000;
            }
            .content {
                max-width: 1450px;
                margin: auto;
            }
            .center {
                margin: auto;
                width: 50%;
            }
        </style>
    </head>
    <body onload="setTimeout('init(<?php echo "$mjpegmode, $video_fps, $divider" ?>);', 100);">
        <div class = "center">
            <h1>Bird Feeder Live Monitor</h1>
            
            <div class="container-fluid text-center liveimage">
                <img id="mjpeg_dest" <?php echo getLoadClass() . getImgWidth();?> src="./loading.jpg"></div>
        </div>
        <div class = "content">
            <?php
                //define variables
                //for sql connection
                $servername = "localhost";
                $username = "jeremy";
                $password = "Password01";
                $dbname = "birdfeeder";
                //for database information
                $year = date("Y");
                $month = date("m");
                $day = date("d");
                $hour = date("H");
                $minute = date("i");
                //other variables
                $y = 0;

                //create connection to mysql
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                //check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                //get the last row ID from climat table
                $sql = "SELECT MAX(ID) AS last_climat FROM climat";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $id = $row["last_climat"];

                //getting information associated to that ID
                //echo "<br> The last ID of the climat table is: " . $id;
                $result = mysqli_query($conn, "SELECT * FROM climat where ID=$id");
                $row = mysqli_fetch_assoc($result);

                echo "<br><br> Temperature: " . $row["Temp"] . "°C";
                echo "<br> Humidity Level: " . $row["Humid"] . "%";
                echo "<br> Reservoir Level: " . $row["Res"] . "%";

                //get last row ID from brids table
                $result = mysqli_query($conn, "SELECT MAX(ID) AS last_id FROM birds");
                $row = mysqli_fetch_array($result);
                $id = $row["last_id"];

                //echo "<br><br>The last ID found is: " , $id , "<br><br>";
                
                //getting the file located in Picture column assicated with the last ID
                $result = mysqli_query($conn, "SELECT ID, Picture from birds where ID=$id");
                $row = mysqli_fetch_assoc($result);

                //echo "<br>The picture associated with that ID is: " . $row["Picture"];

                echo '<h2>Latest Captures of the Feeder</h2>';

                if(mysqli_query($conn,$sql)){
                    while($id>6&&$y<16){
                        $result = mysqli_query($conn, "SELECT ID, Picture from birds where ID=$id");
                        $row = mysqli_fetch_assoc($result);
                        //$image = "image/bird.jpg";
                        //if($image)
                        //echo "<br><br>Image file is:" . $row["Picture"] . "<br><br>";
                        echo '<img src=' . $row["Picture"] . ' width="350"';
                        echo " ";
                        echo "<br>";
                        $y++;
                        $id--;
                    };
                }
            ?>
        </div>
    </body>
</html>