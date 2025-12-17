<?php 
session_start();

$adminid = $_SESSION["admin_id"] ;
$username = $_SESSION["admin_username"]     ;
$lastname = $_SESSION["admin_lastname"]                ;
$firstname = $_SESSION["admin_firstname"]      ;  

// echo $adminid.'<br>';
// echo $username.'<br>';
// echo $lastname.'<br>';
// echo $firstname.'<br>';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abaddon:wght@700&display=swap">
    <title>Admin Home Page</title>
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
            opacity: 0.2; 
        }

        .navbar {
            background-color: #990f02;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button {
            overflow: hidden;
            position: relative;
            width: 280px;
            height: 400px; 
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            background-color: #fff;
        }

        .button img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .button:hover {
            transform: scale(1.05);
        }

        .button a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            text-decoration: none;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            font-size: larger;
        }

        .button:hover a {
            opacity: 1;
        }

        .button p {
            font-size: 18px;
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
</head>
<body>

  
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <img src="../images/Batangas_State_Logo.png" alt="logo" width="110px" height="100px" class="mr-auto">
    
    <a href="adminlogin.php" class="text-warning" style="margin-right: 20px;">
        <i class="bi bi-person-circle" style="font-size: 1.8rem;"></i>
    </a>
</nav>


 
    <div class="button-container">
        <div class="button">
            <img src="../images/add.png" alt="Button 1">
            <a href="addnewitems.php">
                <p>Add Items</p>
            </a>
        </div>

        <div class="button">
            <img src="../images/view.png" alt="Button 2">
            <a href="viewitems.php">
                <p>Items</p>
            </a>
        </div>

        <div class="button">
            <img src="../images/chedits.png" alt="Button 3">
            <a href="edit.php">
                <p>Reservations</p>
            </a>
        </div>
    </div>

</body>
    <footer>
        &copy; Group 2. All Rights Reserved.
    </footer>
</html>
