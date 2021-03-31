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

            //create connection to mysql
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            //check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        ?>
        <br><br>
        <h2>Pictures Captured by the Feeder<h2>
        <?php
            echo "<br><br>Year:" . $year . " Month:" . $month . " Day:" . $day . " Hour:" . $hour . " Minute:" . $minute;
        ?>
    </body>
</html>