<?php
session_start();


if (!isset($_SESSION['SRcode'])) {
   
    header("Location: studlogin.php");
    exit();
}

include '../include/header.php';
include '../database/connection.php';

$sr_code = $_SESSION['SRcode'];
$itemID = $_GET['itemID'];
$itemName = $_GET['itemName'];
$size = $_GET['size'];
$price = $_GET['price'];


$resDate = date('Y-m-d');

if (isset($_POST['confirm'])) {
    $chosenSize = $_POST['chosen_size'];
    $quantity = $_POST['quantity'];
    $Tprice = $_POST['price'];
   // $fixedPrice = $_POST['fixedPrice'];

    $query = "INSERT INTO tbreservedetails (itemid, itemSize, quantity, SRcode, reservation_date) 
              VALUES ('{$itemID}', '{$chosenSize}', '{$quantity}', '{$sr_code}', '{$resDate}')";
    
    $reserve = mysqli_query($conn, $query);

    if (!$reserve) {
        echo "Something went wrong: " . mysqli_connect_error();
    } else {
       
        // $updatedStock = $stock - $quantity;
        // $updateStockQuery = "UPDATE tbproductinfo SET stocks = '{$updatedStock}' WHERE itemID = '{$itemID}'";
        // $updateStockResult = mysqli_query($conn, $updateStockQuery);

        // if (!$updateStockResult) {
        //     echo "Error updating stock: " . mysqli_connect_error();
        // } else {
            echo "<script type='text/javascript'>alert('Your reservation was sent to the RGO.'); window.location.href = 'studHome.php';</script>";
        // }
    }
}
?>

<header>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-center align-items-center">
                <img src="../images/Batangas_State_Logo.png" class="img pt-2" id="logo" alt="BSU Logo">
                <div class="logo_label ms-2">Online Uniform Reservation for RGO</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-content-center align-items-center">
            <div class="logo_sub_label">Uniform Reservation Form</div>
        </div>
    </div>
</header>

<div class="container pt-3" style="width: 800px;">
    <div class="border bg-light" style="width: 600px; height: auto;">
        <form action="" method="post">
            <div class="row g-3 p-2 pt-3 align-items-left justify-content-left ">
                <div class="col-auto text-start">
                    <label for="SRcode" class="col-form-label" style="margin-left: 20px; margin-top: 20px;">SR-Code</label>
                </div>
                <div class="col-auto">
                    <input type="text" id="SRcode" class="form-control" style="margin-left: 50px; width: 300px; margin-top: 20px;" value="<?php echo $sr_code ?>" readonly>
                </div>
            </div>
            <div class="row g-3 p-2 pt-3 align-items-left justify-content-left">
                <div class="col-auto text-start">
                    <label for="item" class="col-form-label" style="margin-left: 20px;">Item</label>
                </div>
                <div class="col-auto">
                    <input type="text" id="item" name="item" class="form-control"  value="<?php echo $itemName ?>" style="margin-left: 80px; width: 300px;" readonly>
                </div>
            </div>

            <div class="row g-3 p-2 pt-3 align-items-left justify-content-left">
                <div class="col-auto text-start">
                <label for="chosen_size" class="col-form-label" style="margin-left: 20px;">Size:</label>
            </div>
               
            <div class="col-auto">
                <input type="text" id="chosen_size" name="chosen_size" class="form-control" placeholder="Please specify the size." style="margin-left: 85px; width: 300px;" required>
                </div>
            </div>

            <div class="row g-3 p-2 pt-3 align-items-left justify-content-left">
                <div class="col-auto text-start">
                    <label for="quantity" class="col-form-label" style="margin-left: 20px;">Quantity</label>
                </div>

                <div class="col-auto">
                    <input type="number" id="quantity" name="quantity" class="form-control" value=1
                        oninput="calculatePrice(<?php echo $price; ?>)"  style="margin-left: 59px; width: 300px;" required>
                </div>
            </div>

            <div class="row g-3 p-2 pt-3 align-items-left justify-content-left">
                <div class="col-auto text-start">
                    <label for="Rdate" class="col-form-label" style="margin-left: 20px;">Date</label>
                </div>

                <!-- <script>
                    function getCurrentDate() {
                        const now = new Date();
                        const year = now.getFullYear();
                        const month = (now.getMonth() + 1).toString().padStart(2, '0');
                        const day = now.getDate().toString().padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    }

                    document.getElementById('Rdate').value = getCurrentDate();
                </script> -->

                <div class="col-auto">
                    <input type="date" id="Rdate" class="form-control"  style="margin-left: 85px; width: 300px;">
                </div>
            </div>
            <div class="row g-3 p-2 pt-3 align-items-left justify-content-left">
                <div class="col-auto text-start">
                    <label for="price" class="col-form-label" style="margin-left: 20px;">Price</label>
                </div>
                <div class="col-auto">
                    <input type="text" id="price" name="price" class="form-control" value="<?php echo $price ?>"  style="margin-left: 85px; width: 300px;"
                        readonly>
                    <input type="hidden" id="fixedPrice" name="fixedPrice" class="form-control" value="<?php echo $price ?>"  style="margin-left: 85px; width: 300px;"
                    readonly>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center pt-1 pb-3" style="margin-top: 30px;">
                <button class="btn btn-success m-2" id="confirm" name="confirm" type="submit" style="width: 150px;">Confirm</button>
                <a href="studHome.php?itemID=<?php echo $itemID?>&itemName=<?php echo $itemName?>&size=<?php echo $size?>&price=<?php echo $price?>" class="btn btn-danger m-2" id="cancel" name="cancel" style="width: 150px;">Cancel</a>
            </div>
        </form>
    </div>
</div>





<?php include '../include/footer.php' ?>