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

            //select get the last row ID from climat table
            $sql = "SELECT MAX(ID) AS last_climat FROM climat";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $id = $row["last_climat"];

            //getting information associated to that ID
            $result = mysqli_query($conn, "SELECT ID, Temp, Humid, Res FROM cimat where ID=$id");
            echo "<br> Current Temperature: " . $row["Temp"];
            echo "  Current Humidity Level: " . $row["Hum"];
            echo "<br> Reservoir Level: " . $row["Res"];

            //get last row ID from brids table
            $result = mysqli_query($conn, "SELECT MAX(ID) AS last_id FROM birds");
            $row = mysqli_fetch_array($result);
            $id = $row["last_id"];

            echo "<br><br>The last ID found is: " , $id , "<br><br>";
            
            //getting the file located in Picture column assicated with the last ID
            $result = mysqli_query($conn, "SELECT ID, Picture from birds where ID=$id");
            $row = mysqli_fetch_assoc($result);
            echo "<br>The picture associated with that ID is: " . $row["Picture"];

            echo '<h2>Latest Captures of the Feeder</h2>';

            if(mysqli_query($conn,$sql)){
                while($id>6&&$y<16){
                    $result = mysqli_query($conn, "SELECT ID, Picture from birds where ID=$id");
                    $image = $row = mysqli_fetch_assoc($result);
                    //$image = "image/bird.jpg";
                    //if($image)
                    //echo "<br><br>Image file is:" . $row["Picture"] . "<br><br>";
                    echo '<img src=' . $row["Picture"] . ' width="250"';
                    echo "<br>";
                    $y++;
                    $id--;
                };
            }
        ?>
    </body>
</html>