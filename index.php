<!DOCTYPE html>
<html>
    <head>
        <title>Smart Bird Feeder</title>
    </head>
    <body>
        <h1>Bird Feeder Live Stream</h1>
        <iframe width=600 height=350 src="vids/test.mp4" title="Live Stream"></iframe>
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
            $x = $day;

            //create connection to mysql
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            //check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            //select data and query
            $sql = "SELECT * FROM birds";
            //$sql = "INSERT INTO birds (Year, Month, Minute) VALUES ('2021', '04', '11')";
            $bird = mysqli_query($conn, $sql);
            $sql = "SELECT max(ID) AS last_id FROM tablename";
            $result = mysqli_query($conn, $sql);

            echo "<br><br>Last inserted ID is:" , $result , "<br><br>";

            echo '<br><br>';
            echo '<h2>Latest Captures of the Feeder</h2>';

            

            //if(mysqli_query($conn,$sql))

            while($x>0&&$y<20){
                //$image = "image/bird.jpg";
                //if($image)
                    echo '<img src="images/bird.jpg" width="250"';
                echo "<br>";
                $y++; 
            };
        ?>
    </body>
</html>