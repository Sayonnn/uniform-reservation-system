<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="../include/functions.js" defer>

    </script>
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
            margin: 150px auto;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            overflow-y:auto;

        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            background-color: #fff;
            text-align:center;
        }

        th,
        td {
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

        .table-container {
            /* Adjust the margin as needed */
            height:300px;
            overflow-y:auto;

        }

        .custom-table {
            width: 90%;
            height:300px;
            top:300px;

        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: center;
        }

     

        .action-buttons button {
            color: #fff;
            margin-right: 5px;
            border-radius: 3px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <img src="../images/Batangas_State_Logo.png" alt="logo" width="110px" height="100px">

        <a href="adminhomepage.php" class="btn btn-warning ml-auto" style="margin-right: 10px; width: 150px;">
            <i class="bi bi-box-arrow-right"></i> Back
        </a>
    </nav>

<body>

    <div class="d-flex justify-content-left"
        style="top: 0; right: 1; z-index: 5; position: fixed; margin-top: -80px;">

        <form class="d-flex" method="post">
            <input class="form-control me-2" type="text" placeholder="Enter Student sr-code" aria-label="Search"
                style="margin-right: 5px; margin-left: 10px; margin-top: 200px" name="srsearch">

            <button class="btn btn-success text-white" type="submit"
                style="margin-right: 10px; margin-top: 200px; width:200px" name="btnsearch">
                <i class="bi bi-search">Search</i></button>
        </form>

    </div>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_nt3101";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['btnsearch'])) {
        //get the sr code in the search input form
        $search = $_POST['srsearch'];
        $search = json_encode($search);

        echo("<script>console.log({$search});</script>");
        
        $sql = "SELECT * FROM `tbreservedetails` WHERE `SRcode` IN ($search)";
        $result = mysqli_query($conn,$sql);

        $totalPrice = 0;

            if($result->num_rows > 0){
            echo "<table class='table custom-table'>";
            echo "<tr><th>Reservation ID</th><th>Item Name</th><th>Item Size</th><th>Quantity</th><th>Total Price</th> <th>Date</th> <th>SR Code</th><th class = 'text-center'>Action</th></tr>";
            $innerSql = "SELECT * FROM tbproductinfo as product JOIN tbreservedetails as reserve on product.itemid = reserve.itemid AND reserve.SRcode = $search ORDER BY reservationid DESC";
            $innerResult = $conn->query($innerSql);
            while ($innerRow = $innerResult->fetch_assoc()) {
                $id = $innerRow['reservationid'];
                
                //autocomputed total price / no attribute in the database
                $totalPrice = $innerRow['quantity'] * $innerRow['price'];

                echo "<tr><td>" . $innerRow["reservationid"] . "</td><td>" . $innerRow["itemname"] . "</td><td>" . $innerRow["itemSize"] . "</td><td>" . $innerRow["quantity"] . "</td><td>" . $totalPrice . "</td><td>" . $innerRow["reservation_date"] . "</td><td>" . $innerRow["SRcode"] . "</td>";
                echo "<td class='text-center'>";
                echo "<form method='post' action='process.php'>";
                echo "<input type='hidden' name='reservation_id' value='" . $innerRow["reservationid"] . "'>";
                $acceptStyle = ($innerRow["status"] == 'accepted') ? 'btn-success' : 'btn-outline-success';
                $declineStyle = ($innerRow["status"] == 'canceled') ? 'btn-danger' : 'btn-outline-danger';
                $pendingStyle = ($innerRow["status"] == 'pending') ? 'btn-warning' : 'btn-outline-warning';
                $nostockStyle = ($innerRow["status"] == 'nostock') ? 'btn-secondary' : 'btn-outline-secondary';
                $newstatus = $innerRow['status'];
                $name = $innerRow['itemname'];
                $price = $innerRow['price'];
                $sr = $innerRow['SRcode'];

                echo "<button type='submit' name='accepted' class='btn {$acceptStyle} mx-1' style = 'border-radius:15px;'>Accept</button>";
                echo "<button type='submit' name='pending' class='btn {$pendingStyle} mx-1' style = 'border-radius:15px;'>Pending</button>";
                echo "<button type='submit' name='nostock' class='btn {$nostockStyle} mx-1'  style = 'border-radius:15px;'>out of Stock</button>";
                echo "<button type='button' name='canceled' class='btn {$declineStyle} mx-2' style = 'border-radius:15px;' onClick = \"sendEmail('{$id}','{$sr}','{$name}','{$price}')\"><i class='fa-solid fa-trash mx-2'></i></button>";
                echo "<button type='button' style = 'border-radius:15px;padding:0;margin:0;' class='btn btn-info  mx-2' onClick = \"sendNote('{$id}','{$newstatus}')\"><i class='fa-solid fa-circle-info' style = 'font-size:30px;margin:0;' ></i></button>";
                echo "</form>";
                echo "</td></tr>";
            }
                echo "</table>";
        }else {
            echo "0 results";
        }
    } else {

        $sql = "SELECT * FROM tbreservedetails";
        $result = $conn->query($sql);
        $totalPrice = 0;

        if ($result->num_rows > 0) {
            
            echo "<table class='table custom-table'>";
            echo "<tr><th>Reservation ID</th><th>Item Name</th><th>Item Size</th><th>Quantity</th><th>Total Price</th> <th>Date</th> <th>SR Code</th><th class = 'text-center'>Action</th></tr>";
            $innerSql = "SELECT * FROM tbproductinfo as product JOIN tbreservedetails as reserve on product.itemid = reserve.itemid ORDER BY reservationid DESC";
            $innerResult = $conn->query($innerSql);
            while ($innerRow = $innerResult->fetch_assoc()) {
                $id = $innerRow['reservationid'];
                
                //autocomputed total price / no attribute in the database
                $totalPrice = $innerRow['quantity'] * $innerRow['price'];

                echo "<tr><td>" . $innerRow["reservationid"] . "</td><td>" . $innerRow["itemname"] . "</td><td>" . $innerRow["itemSize"] . "</td><td>" . $innerRow["quantity"] . "</td><td>" . $totalPrice . "</td><td>" . $innerRow["reservation_date"] . "</td><td>" . $innerRow["SRcode"] . "</td>";
                echo "<td class='text-center'>";
                echo "<form method='post' action='process.php'>";
                echo "<input type='hidden' name='reservation_id' value='" . $innerRow["reservationid"] . "'>";
                $acceptStyle = ($innerRow["status"] == 'accepted') ? 'btn-success' : 'btn-outline-success';
                $declineStyle = ($innerRow["status"] == 'canceled') ? 'btn-danger' : 'btn-outline-danger';
                $pendingStyle = ($innerRow["status"] == 'pending') ? 'btn-warning' : 'btn-outline-warning';
                $nostockStyle = ($innerRow["status"] == 'nostock') ? 'btn-secondary' : 'btn-outline-secondary';
                $newstatus = $innerRow['status'];
                $name = $innerRow['itemname'];
                $price = $innerRow['price'];
                $sr = $innerRow['SRcode'];

                echo "<button type='submit' name='accepted' class='btn {$acceptStyle} mx-1' style = 'border-radius:15px;'>Accept</button>";
                echo "<button type='submit' name='pending' class='btn {$pendingStyle} mx-1' style = 'border-radius:15px;'>Pending</button>";
                echo "<button type='submit' name='nostock' class='btn {$nostockStyle} mx-1'  style = 'border-radius:15px;'>out of Stock</button>";
                echo "<button type='button' name='canceled' class='btn {$declineStyle} mx-2' style = 'border-radius:15px;' onClick = \"sendEmail('{$id}','{$sr}','{$name}','{$price}')\"><i class='fa-solid fa-trash mx-2'></i></button>";
                echo "<button type='button' style = 'border-radius:15px;padding:0;margin:0;' class='btn btn-info  mx-2' onClick = \"sendNote('{$id}','{$newstatus}')\"><i class='fa-solid fa-circle-info' style = 'font-size:30px;margin:0;' ></i></button>";
                echo "</form>";
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
    }

    ?>

    <?php

    if (isset($_POST['btnNote'])) {

        $id = $_POST['hiddenid'];
        $note = $_POST['notebody'];
        $status = $_POST['selectStatus'];

        $sql = "SELECT * FROM tbstatus WHERE reservationid = " . $id . "";
        $query = $conn->query($sql);
        $results = mysqli_num_rows($query);
        ///echo("<script>alert({$results});</script>");
    
        if ($results >= 1) {
            $sql3 = "UPDATE `tbstatus` SET `reservationid`='{$id}',`resStatus`='{$status}',`statusNote`='{$note}' WHERE `Reservationid` = '{$id}'";
            $query = mysqli_query($conn, $sql3);
        } else {
            $sql3 = $conn->prepare("INSERT INTO `tbstatus`(`reservationid`, `resStatus`, `statusNote`) VALUES (?,?,?)");
            $sql3->bind_param("iss", $id, $status, $note);
            $sql3->execute();
        }
    }

    ?>
    <!-- status modal or status information -->
    <div class=" mb-5 w-25 " id="createNote"
        style="display:none;background-color:#f8f9fa;height:100vh;background-color:rgba(255,255,255,0.8);background-size:cover;background-blend-mode:overlay;z-index:2;border-radius:15px;position:absolute;height:auto;box-shadow:0 0 20px black;">
        <form method="POST">
            <div class="col text-center">
                <h2 class="fs-2 m-2">Note</h2>
                <input type="hidden" name="hiddenid" id="hiddenid">

                <input name="selectStatus" id="selectStatus" class="position-absolute  "
                    style="border:none;border-radius:15px;font-size:12px;padding:1rem;right:10px;top:0;width:80px;height:20px">
                <!-- <option value="" selected required></option>
                    <option value="accepted">accepted</option>
                    <option value="canceled">canceled</option>
                    <option value="pending">pending</option>
                    <option value="out of stock">out of stock</option> -->
                </input>

                <div class="row d-flex justify-content-center align-items-center my-5 ">
                    <textarea type="textarea" class=" form-control  w-50" id="notebody" name="notebody"
                        required></textarea>
                </div>

                <div class="row d-flex justify-content-center align-items-center mb-5 my-3">
                    <button type="button " class="btn btn-danger btn-sm p-1  w-25 mx-2" id="btnNote" name=""
                        onClick="closeNote();">Close</button>
                    <button type="submit " class="btn btn-success btn-sm p-1 mx-2  w-25" id="btnNote"
                        name="btnNote">Send
                        Note</button>

                </div>
            </div>
        </form>
    </div>


    <!-- part for sending email to delte on studnet -->
    <div class=" mb-5 w-25 " id="createEmail" style="display:none;background-color:#f8f9fa;height:100vh;background-color:rgba(255,255,255,0.8);background-size:cover;background-blend-mode:overlay;z-index:2;border-radius:15px;position:absolute;height:auto;box-shadow:0 0 20px black;text-align:center;">
        <form method="POST">
            <div class="col text-center">
                <h2 class="fs-4 m-2">Send Email</h2>
                <input type="hidden" name="itemid" id="itemid">
                <input type="hidden" name="sremail" id="sremail">
                <input type="hidden" name="itemname" id="itemname">
                <input type="hidden" name="itemprice" id="itemprice">


                <input name="subject" id="subject" class="form-control w-50 mt-4" placeholder = "Email Title">
               
                </input>

                <div class="row d-flex justify-content-center align-items-center my-4 ">
                    <textarea type="textarea" class=" form-control  w-75"  name="emailbody" placeholder="Message..."
                        required></textarea>
                </div>

                <div class="row d-flex justify-content-center align-items-center mb-5 my-3">
                    <button type="button " class="btn btn-danger btn-sm p-1  w-25 mx-2" id="" name=""
                        onClick="closeEmail();">Close</button>
                    <button type="submit " class="btn btn-success btn-sm p-1 mx-2  w-25" id="btnEmail"
                        name="btnEmail">Send
                        Note</button>

                </div>
            </div>
        </form>
    </div>
    <?php 

               if(isset($_POST['btnEmail'])){
                    $id = $_POST['itemid'];
                    $sr = $_POST['sremail'];
                    $name = $_POST['itemname'];
                    $price = $_POST['itemprice'];

                    $subject = $_POST['subject'];
                    $message = $_POST['emailbody'];
                $sql = "DELETE FROM tbreservedetails WHERE reservationid = {$id}";
                $query = mysqli_query($conn,$sql);
                if($query){
                    // header('Location:../include/rgomail.php?itemid='.$id.'&itemname='.$name.'&price='.$price.'&subject='.$subject.'&message='.$message.'&sr='.$sr.'');
                    echo
                        " 
                        <script> 
                        alert('Email was sent successfully!');
                        document.location.href = '../include/rgomail.php?itemid=$id&itemname=$name&price=$price&subject=$subject&message=$message&sr=$sr';
                        </script>
                        ";

                }else{
                    "Error submitting email";
                }
            }


        ?>



 <!-- create email for student reaservationd deletion  -->
</body>
<footer>
    &copy; Group 2. All Rights Reserved.
</footer>

</html>