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

            //create connection to mysql
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            //check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        ?>
        <br><br>
        <h2>Pictures Captured by the Feeder</h2>
        <?php
            $x = $day;

            while($x>0&&$y<30){
                echo '<img src="https://cdn2.jomashop.com/media/catalog/product/c/i/citizen-cto-men_s-watch-bu4020-01l.jpg" width="250"';
                $y++; 
            };
        ?>
    </body>
</html>