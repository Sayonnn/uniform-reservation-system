<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_nt3101";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginError = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST["userName"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT acc.empid, acc.username, emp.lastname, emp.firstname FROM tbadminacc AS acc JOIN tbempinfo AS emp ON acc.empid = emp.empid WHERE emp.firstname = ? AND emp.lastname = ?");
    $stmt->bind_param("ss", $userName, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        session_start();
        $_SESSION["admin_id"] = $user["empid"];
        $_SESSION["admin_username"] = $user["username"];
        $_SESSION["admin_lastname"] = $user["lastname"];
        $_SESSION["admin_firstname"] = $user["firstname"];  
        header("Location: adminhomepage.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}

$conn->close();
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="../include/styles.css" rel="stylesheet">
    <script src="../include/functions.js" defer></script>
</head>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh; 
}

.navbar {
            background-color: #990f02;
        }


.card {
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 400px;
    align-self: center;
    margin: auto; 
}


.logo {
    text-align: center;
}

.logo-img {
    width: 200px;
    height: 200px; 
    margin-top: 10px;
}

.card-title {
    color: #495057;
}

.form-label {
    color: #495057;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.btn-primary {
    background-color: #007bff;
    border: 1px solid #007bff;
    margin-bottom: 30px;
    width: 50%;
    display: block;
    align-items: center;
    margin: 0 auto;

}

.btn-primary:hover {
    background-color: #0056b3;
    border: 1px solid #0056b3;
}
footer {
            background-color: #990f02;
            padding: 10px;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 80px;
            text-align: center;
        }

</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <img src="../images/Batangas_State_Logo.png" alt="logo" width="110px" height="100px" class="mr-auto">
    
    <a href="adminlogin.php" class="text-warning" style="margin-right: 20px;">
        <i class="bi bi-person-circle" style="font-size: 1.8rem;"></i>
    </a>
</nav>

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
            <div class="logo_sub_label">Admin Login</div>
        </div>
    </div>
</header>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-3 mb-5 bg-white rounded">
            <div class="logo">
                <img src="../images/Batangas_State_Logo.png" alt="Logo" style="width: 110px; height: 100px;">
            </div>

            
<br>
                <h3 class="card-title text-center"><strong>Log In</strong></h3>
                <form action="adminlogin.php" method="post">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Username</label>
                        <input type="text" id="userName" name="userName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <?php if ($loginError): ?>
                        <p class="text-danger"><?php echo $loginError; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
        &copy; Group 2. All Rights Reserved.
    </footer>