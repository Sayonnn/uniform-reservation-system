<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_nt3101";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = $_POST['reservation_id'];


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    if (isset($_POST['accepted'])) {
    
        $updateSql = "UPDATE tbreservedetails SET status = 'accepted' WHERE reservationid = $reservationId";
        $conn->query($updateSql);
    } elseif (isset($_POST['canceled'])) {
       
        $updateSql = "UPDATE tbreservedetails SET status = 'canceled' WHERE reservationid = $reservationId";
        $conn->query($updateSql);
    } elseif (isset($_POST['pending'])) {
      
        $updateSql = "UPDATE tbreservedetails SET status = 'pending' WHERE reservationid = $reservationId";
        $conn->query($updateSql);
    }else{
      
        $updateSql = "UPDATE tbreservedetails SET status = 'nostock' WHERE reservationid = $reservationId";
        $conn->query($updateSql);
    }

   
    $conn->close();
}


header("Location: edit.php");
?>
