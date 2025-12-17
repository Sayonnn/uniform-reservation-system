<?php 
session_start();
include '../include/header.php';
include '../database/connection.php' ?>


<?php
if (isset($_POST['login'])) {
    // Retrieve values from the form
    $password = $_POST["password"];
    $sr_code = $_POST["SRcode"];

    // SQL query to check if the credentials are valid
    $query = "SELECT * FROM tbstudacc WHERE password = '{$password}' AND SRcode = '{$sr_code}'";

    //SELECT * FROM tbstudacc AS acc JOIN tbstudinfo AS stud ON acc.studid = ? WHERE acc.studid = $id
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Authentication successful
        $row = mysqli_fetch_assoc($result);
        $_SESSION['SRcode'] = $sr_code;
        $_SESSION['studid'] = $row['studid'];
        //$studid = $_SESSION['studid'];
       // $srcode = $sr_code;

        echo "<script type='text/javascript'>alert('Login successful! $studid $srcode'); window.location.href = 'studHome.php?srcode={$sr_code}';</script>";
    } else {
        // Authentication failed
        echo "<script type='text/javascript'>alert('Login failed. Please check your credentials.');</script>";
    }
}
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
            <div class="logo_sub_label">Student Login</div>
        </div>
    </div>
</header>

<div class="container mt-5 pt-3" style="width: 22%; height: 50%; border-radius: 10px;  width: 400px; " >
    <div class="border bg-light">
        <img src="../images/Batangas_State_Logo.png" alt="Your Image" class="img-fluid mx-auto d-block" style="width: 100px; margin-top: 30px; margin-bottom: 30px;">

        <form method="post">
            <div class="row g-3 p-2 pt-3 align-items-center justify-content-center" style="height: 30%; ">
                <!-- Empty row for spacing -->
            </div>

            <div class="row g-3 p-2 align-items-center justify-content-center">
                <div class="col-12 text-left">
                    <label for="SRcode" class="col-form-label" style="margin-left: 30px;">SR-Code</label>
                    <input type="text" id="SRcode" name="SRcode" class="form-control mx-auto" style="width: 300px;" required>
                </div>
            </div>

            <div class="row g-3 p-2 align-items-center justify-content-center">
                <div class="col-12 text-left">
                    <label for="password" class="col-form-label" style="margin-left: 30px;">Password</label>
                    <input type="password" id="password" name="password" class="form-control mx-auto" style="width: 300px;" required>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center pt-1 pb-3">
                <button class="btn btn-primary" id="login" name="login" type="submit" role="button" style="width: 150px; margin-top: 30px;">Login</button>
            </div>
        </form>
    </div>
</div>



<?php include '../include/footer.php'; ?>