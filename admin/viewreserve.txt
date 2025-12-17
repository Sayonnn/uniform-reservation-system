<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>View Reservations</title>
    
    <style>
       body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
            position: relative;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url(../images/bg22.jpg);
            background-size: cover;
            z-index: -1;
            opacity: 0.5; 
        }
        
        .navbar {
            background-color: #990f02;
        }

        
    

        table {
            border-collapse: collapse;
            width: 50%;
            margin: 150px auto;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-top: 50px;
 
            }

        table, th, td {
            border: 1px solid #ddd;
            background-color: #fff;
            
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        footer {
            background-color: #990f02;
            padding: 10px;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            height: 80px;
        }
       
</style>



<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <img src="../images/Batangas_State_Logo.png" alt="logo" width="110px" height="100px">
      
        <a href="adminhomepage.php" class="btn btn-warning ml-auto" style="margin-right: 10px; width: 150px;">
            <i class="bi bi-box-arrow-right"></i> Back
         </a>
</nav>  



       
<body>


<div class="d-flex justify-content-left" style="top: 0; right: 1; z-index: 999; position: fixed; margin: right -50px;">

        <form class="d-flex" method="post">
    <input class="form-control me-2" type="text" placeholder="Enter Student sr-code" aria-label="Search" style="margin-right: 5px; margin-left: 10px; margin-top: 200px" name = "srsearch" >

    <button class="btn btn-success text-white" type="submit" style="margin-right: 10px; margin-top: 200px; width:200px" name = "btnsearch">
    <i class="bi bi-search" >Search</i></button>
        </form>

    </div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_nt3101";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['btnsearch'])){

    $srcode = $_POST['srsearch'];
    //make string print hyphen 
    $srcode = json_encode($srcode);

    // echo("<script>console.log(".$srcode.")</script>");
    //get the srcode from the search input
    $sql = "SELECT reservationid, itemid, itemSize, quantity, reservation_date, SRcode FROM tbreservedetails WHERE SRcode LIKE ".$srcode."" ;
    $result = $conn->query($sql);
    $innerSql = "SELECT * FROM tbproductinfo as product JOIN tbreservedetails as reserve on product.itemid = reserve.itemid WHERE SRcode = ".$srcode."" ;
    $innerResult = $conn->query($innerSql);

    if ($result && $innerResult &&  $innerResult->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Reservation ID</th><th>Item ID</th><th>Item Name</th><th>Item Size</th><th>Quantity</th><th>Total Price</th><th>Date</th><th>SR Code</th></tr>";
        while($row = $result->fetch_assoc()) {
            $innerRow = $innerResult->fetch_assoc();
            //auto computed photoeditor.aitotal price / no attribute in database
            $totalPrice = $innerRow['quantity'] * $innerRow['price'];

            echo "<tr><td>" . $row["reservationid"] . "</td><td>" . $row["itemid"] . "</td><td>" . $innerRow["itemname"] . "</td><td>" . $row["itemSize"] . "</td><td>" . $row["quantity"] . "</td><td>" . $totalPrice . "</td><td>" .$row["reservation_date"]."</td><td>" .$row["SRcode"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}else{
    
    $sql = "SELECT reservationid, itemid, itemSize, quantity, reservation_date, SRcode FROM tbreservedetails";
    $result = $conn->query($sql);
    $innerSql = "SELECT * FROM tbproductinfo as product JOIN tbreservedetails as reserve on product.itemid = reserve.itemid";
    $innerResult = $conn->query($innerSql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Reservation ID</th><th>Item ID</th><th>Item Name</th><th>Item Size</th><th>Quantity</th><th>Total Price</th><th>Date</th><th>SR Code</th></tr>";
        while($row = $result->fetch_assoc()) {
            $innerRow = $innerResult->fetch_assoc();
            //auto computed total price / no attribute in database
            $totalPrice = $innerRow['quantity'] * $innerRow['price'];

            echo "<tr><td>" . $row["reservationid"] . "</td><td>" . $row["itemid"] . "</td><td>" . $innerRow["itemname"] . "</td><td>" . $row["itemSize"] . "</td><td>" . $row["quantity"] . "</td><td>" . $totalPrice . "</td><td>" .$row["reservation_date"]."</td><td>" .$row["SRcode"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}

$conn->close();
?>

</body>
    <footer>
        &copy; Group 2. All Rights Reserved.
    </footer>
</html>
