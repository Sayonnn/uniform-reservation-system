<?php
session_start();

// Check if SRcode is set in the session
if (!isset($_SESSION['SRcode'])) {
    // Redirect to login page if SRcode is not set
    header("Location: studlogin.php");
    exit();
}

include '../include/header.php';
include '../database/connection.php';

$srcode = $_SESSION['SRcode'];


?>

<header>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-center align-items-center">
                <img src="../images/Batangas_State_Logo.png" class="img pt-2" id="logo" alt="BSU Logo">
                <div class="logo_label ms-2 ">Online Uniform Reservation for RGO</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-content-center align-items-center">
            <div class="logo_sub_label">Student Portal</div>
        </div>
    </div>
</header>

<div class="container">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <button class="nav-link active" aria-current="true" id="pills-home-tab"
                        onclick="changeContent('studHome_Main', 'pills-home-tab')">Home</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="pills-profile-tab"
                        onclick="changeContent('studHome_ItemList', 'pills-profile-tab')">Uniforms</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="pills-contact-tab"
                        onclick="changeContent('studHome_Logout', 'pills-contact-tab')">Log Out</button>
                </li>
                <a class = "btn btn-danger btn-sm m-1" style ="position:absolute;right:130px;" href ="../include/mail.php?srcode=$srcode" ><i class="fa-solid fa-envelope mx-2"></i>Notify RGO</a>
                <button class = "btn btn-danger btn-sm m-1 position-absolute end-0 t-0" data-bs-toggle='modal' data-bs-target='#receiptInfo'><i class="fa-solid fa-receipt mx-2"></i>Reservations</button>
            </ul>
        </div>

        <!--Main Home Section/Tab-->
        <div class="card-body" id="studHome_Main" style="display: block;">
        <style>
         .container {
                margin-top: 80px;
                height: auto;
                max-height: calc(100vh - 300px); /* Set a maximum height to fit the remaining viewport space */
                width: 100%;
                overflow-y: auto; /* Add scrollbars when the content exceeds the height */
            }
            #studHome_Main {
                text-align: center;
            }

            #itemList {
                width: 100%; 
            }
            #itemList th {
                max-width: calc(100% / 3); 
                overflow: hidden;
                align-self: center;
            }
        </style>

            <!--Legend-->
            <div class="d-flex align-text-center justify-content-center">
                <div class="mx-1" style="font-size:10px;">
                    <button class="btn btn-success btn-sm mx-0 "></button>
                    Accepted
                </div>
                <div class="mx-1" style="font-size:10px;">
                    <button class="btn btn-warning btn-sm mx-0"></button>
                    Pending
                </div>
                <div class="mx-1" style="font-size:10px;">
                    <button class="btn btn-danger btn-sm mx-0"></button>
                    Cancelled
                </div>
            </div>
            <table id="itemList">
                <thead>
                    <tr>
                        <th class="text-center">Reservation ID</th>
                        <th class="text-center">Reservation Details</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //fetch items base on srcode 
                    $reservationQuery = "SELECT * FROM tbreservedetails WHERE SRcode = '{$_SESSION['SRcode']}'";
                    $reservationResult = mysqli_query($conn, $reservationQuery);
                    $numReservations = mysqli_num_rows($reservationResult);
                    if ($numReservations > 0) {  //if fetching data successfull
                            
                        $query = "SELECT * FROM tbreservedetails JOIN tbproductinfo ON tbreservedetails.itemid = tbproductinfo.itemid WHERE SRcode='{$_SESSION['SRcode']}' ORDER BY reservationid DESC";


                        //can get srcode  with its status here and id, size and many more
                        $display = mysqli_query($conn, $query);
                    
                        while ($row = mysqli_fetch_assoc($display)) {

                            $resID = $row['reservationid'];
                           
                            $itemName = $row['itemname'];
                            $itemPIC = $row['item_img'];
                            $base64IMG = base64_encode($itemPIC);
                            $size = $row['itemSize'];
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            //auto computed Tprice / no attribute in the databse
                            $Tprice = $row['price'] * $row['quantity'];
                            
                            // Retrieve the reservation status directly from tbreservedetails
                            $status = $row['status'];

                            //fetch status data every loop base on reservationid
                            $sql2 = 'select * from tbstatus  WHERE reservationid = '.$resID.'';
                            $query2 = mysqli_query($conn, $sql2);

                             //fethcing from the tbstatus
                            $row2 = mysqli_fetch_assoc($query2);
                            $id = (!empty($row2['reservationid'])) ? $row2['reservationid'] : "";
                            $newstatus = (!empty($row2['resStatus'])) ? $row2['resStatus'] : "";
                            $notes = (!empty($row2['statusNote'])) ? $row2['statusNote'] : 'No Reminder from RGO';

                            //tester of data
                            // echo $resID.'<br>';
                            // echo $newstatus.'<br>';
                            // echo $notes.'<br>';

                           
                            // Assign color based on status
                            if ($status == 'pending') {
                                $color = 'warning';
                            } elseif ($status == 'accepted') {
                                $color = 'success';
                            } elseif ($status == 'canceled') {
                                $color = 'danger';
                            } 
                            else {
                                $color = 'secondary';
                            }
                    

                            echo "<tr class='item'>";
                            echo "<th><div class='d-flex justify-content-center'>{$resID}</div></th>";
                            echo "<td>
                                    <div class='row row-cols-3 '>
                                        <div class='row '>
                                            <div class='d-flex justify-content-center align-items-center'>
                                                <img src='data:image/jpeg;base64,{$base64IMG}' alt='Item 1' class='item-image' onclick=\"openModal('{$base64IMG}')\">
                                            </div>
                                        </div>
                                        <div class='col'>
                                            <div class='desc d-flex justify-content-center'>Item:</div>
                                            <div class='desc d-flex justify-content-center'>Size:</div>
                                            <div class='desc d-flex justify-content-center'>Quantity:</div>
                                            <div class='desc d-flex justify-content-center'>Price:</div>
                                        </div>
                                        <div class='col'>
                                            <div class='desc d-flex justify-content-center'>{$itemName}</div>
                                            <div class='desc d-flex justify-content-center'>{$size}</div>
                                            <div class='desc d-flex justify-content-center'>{$quantity}</div>
                                            <div class='desc d-flex justify-content-center'>{$Tprice}</div>
                                        </div>
                                    </div>
                                    <th>
                                        <div class='d-flex justify-content-center'>
                                        <form method = 'post'>
                                            <button type='button' class='btn btn-$color btn-lg' data-bs-toggle='modal' data-bs-target='#statusInfo' name = 'btnStatus' onClick = \"changeNote('{$resID}','{$newstatus}','{$notes}')\">  </button>
                                        </form>
                                        </div>  
                                    </th>
                            </td>
                            </tr>";
                        }
                    } else {
                        echo "You currently have no reservation.";
                    }
                    ?>
                </tbody>
            </table>
            <!-- status modal or status information -->
                
            <div class="modal fade" id="statusInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="statusInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <button class = "btn" id = "1stpara"></button>

                        <h5 class="modal-title" id="statusInfoLabel">Reminder</h5>
                        
                        <button class = "btn" id = "2ndpara"></button>

                    </div>
                    <div class="modal-body">
                        <p id = "3rdpara"></p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            </div>
          

             <!-- order receipt modal  -->
             <div class="modal fade" id="receiptInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="receiptInfoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" >
                    <div class="modal-content" >
                        
                        <div class="modal-body" id = "receiptContainer">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptInfoLabel">Reservation Information</h5>
                        </div>
                            <img src="../images/Batangas_State_Logo.png" class="img pt-2" id="logo" alt="BSU Logo">
                            <p class ="my-1">Resource Generation Office </p>
                            <p class ="my-2">Lipa Campus</p>
                            <div class = "row row-cols-2">
                                <div class="col">
                                    <p class ="my-1">Student: <?php echo $_SESSION['SRcode'];?></p>
                                </div>
                                <div class="col">
                                    <p class ="my-1">Date: <?php date_default_timezone_set('Asia/Manila'); echo date("d-n-Y");?></p>
                                </div>
                            </div>
                            <p class ="my-2">=======================================</p>
                            <?php 
                             $total = 0;
                             $reservationQuery = "SELECT * FROM tbreservedetails WHERE SRcode = '{$_SESSION['SRcode']}'";
                             $reservationResult = mysqli_query($conn, $reservationQuery);
                             $numReservations = mysqli_num_rows($reservationResult);
                             
                             if ($numReservations > 0) {
                                 $query = "SELECT * FROM tbreservedetails JOIN tbproductinfo ON tbreservedetails.itemid = tbproductinfo.itemid WHERE SRcode='{$_SESSION['SRcode']}' ORDER BY reservationid DESC";
                                 $display = mysqli_query($conn, $query);
                             
                                 while ($row = mysqli_fetch_assoc($display)) {
                                     $resID = $row['reservationid'];
                                     $itemName = $row['itemname'];
                                    //  $itemPIC = $row['item_img'];
                                    //  $base64IMG = base64_encode($itemPIC);
                                     $size = $row['itemSize'];
                                     $quantity = $row['quantity'];
                                     $price = $row['price'];
                                     //auto computed Tprice / no attribute in the databse
                                     $Tprice = $row['price'] * $row['quantity'];
                                     $total += $Tprice;
                                     echo '
                                     <div class = "row row-cols-3">
                                        <div class = "col">
                                            <p class = "fw-bold text-danger"> Reservation: '.$resID.'       </p>
                                            <p  class = "fw-bold"> Item: '.$itemName.'       </p>
                                        </div>
                                        <div class = "col">
                                            <p> Size: '.$size.'       </p>
                                            <p> Quantity: '.$quantity.'       </p>
                                        </div>
                                        <div class = "col">
                                            <p> Price: '.$price.'       </p>
                                            <p  class = "text-decoration-underline"> Total: '.$Tprice.'       </p>
                                        </div>
                                     </div>
                                     =======================================
                                     ';
                                    }
                                 }
                            ?>
                            <h5 class = "m-3">Total Price: <?php echo $total?></h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-secondary" onClick = "window.print();">Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal 1 for hom tab -->
            <div id="bigPIC_container" class="modal">
                <img class="modal-content" id="bigPIC">
            </div>
        </div>

        <!--Home Page Uniform Section/Tab-->
        <div class="card-body" id="studHome_ItemList" style="display: none;">
            <table id="itemList">
                <thead>
                    <tr>
                        <th class="text-center">Item</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM tbproductinfo ORDER BY itemname";
                    $display = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($display)) {
                        $itemID = $row['itemid'];
                        $itemName = $row['itemname'];
                        $itemPIC = $row['item_img'];
                        $base64 = base64_encode($itemPIC);
                        $size = $row['sizes'];
                        $price = $row['price'];
                        
                        echo "<tr class='item'>";
                        echo "<th><div class='d-flex justify-content-center'>{$itemName}</div></th>";
                        echo "<td>
                        <div class='row row-cols-2 '>
                            <div class='row'>
                                <div class='d-flex justify-content-center align-items-center'>
                                    <img src='data:image/jpeg;base64,{$base64}' alt='Item 1' class='item-image' onclick=\"openModal2('{$base64}')\">
                                </div>
                            </div>
                            <div class='col'>
                                <div class='desc'>Size: {$size}</div>
                                <div class='desc'>Price: {$price}</div>
                            </div>
                        </div>
                    </td>";
                        echo "<td>
                        <div class='d-flex justify-content-center'>
                        <a href='reservationForm_Stud.php?itemID={$itemID}&itemName={$itemName}&size={$size}&price={$price}' class='btn btn-danger reserve-button'>Reserve</a>
                        </div>
                    </td>";
                    }
                    ?>
                </tbody>
            </table>
            <!-- modal for uniform image click -->
            <div id="bigPIC_container1" class="modal">
                <img class="modal-content" id="bigPIC1">
            </div>
        </div>


        <!-- Log Out Section/Tab -->
        <div class="card-body" id="studHome_Logout" style="display: none;">
            <?php
            $sr = $_SESSION['SRcode'];
            $id = $_SESSION['studid'];
            //var_dump($id);
           // echo($id);
            $query = "SELECT * FROM tbstudacc AS acc JOIN tbstudinfo AS stud ON acc.studid = ? WHERE acc.studid = $id";
           
            // echo($sr);
            // Use prepared statement to prevent SQL injection
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Check if the query was successful
            if (mysqli_stmt_execute($stmt)) {

                $nameFetch = mysqli_stmt_get_result($stmt);
                // inner queries
                $innersql = "SELECT * from tbstudinfo WHERE studid = $id";
                $innerquery = mysqli_query($conn,$innersql);

                while($innerfetch = mysqli_fetch_assoc($innerquery)){
                    $_SESSION['fname'] = $innerfetch['firstname'];
                    $_SESSION['Lname'] = $innerfetch['lastname'];
                    
                }
                //session variables from the inner query
                $fname = $_SESSION['fname'];
                $lname = $_SESSION['Lname'];

                // Check if there is a row in the result
                while ($row = mysqli_fetch_assoc($nameFetch)) {
                    $Fname = $row['firstname'];
                    $Lname = $row['lastname'];
                   if($fname == $Fname && $lname = $Lname){

                    echo "<div class='d-flex justify-content-center m-2'>
                            <h3 class='text-center'>You are currently logged in as {$Fname} {$Lname}. Do you want to logout?</h3>
                        </div>";
                    echo "<div class='d-flex justify-content-center'>
                            <button type='button' name='logout' class='btn btn-danger' onclick='logoutMes()'>Logout</button>
                        </div>";
                    break;
                   }  
                } 
             
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error in the query: " . mysqli_error($conn);
            }
            ?>
        </div>

    </div>
</div>

<?php include '../include/footer.php'; ?>