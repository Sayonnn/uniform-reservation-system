<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_nt3101";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item = $_POST["itemname"];
    $size = isset($_POST["sizes"]) ? $_POST["sizes"] : '';
    $price = $_POST["price"];
    
    //$imageData = file_get_contents($_FILES["item_img"]["tmp_name"]);
    // $imageData = base64_encode($imageData); // Convert to base64 for storage
    $filename = $_FILES["item_img"]["name"];
    $tempname = $_FILES["item_img"]["tmp_name"];
    $folder = "../images/" . $filename;
    
    if (move_uploaded_file($tempname, $folder)) {
        $stmt = $conn->prepare("INSERT INTO tbproductinfo (itemname, item_img, sizes, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $item, $filename, $size, $price);
    
        if ($stmt->execute()) {
         //   echo "New record created successfully";
            header("Location: addnewitems.php?message=Insert Successful");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }

   
}

$conn->close();
?>






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
            font-family: 'Arial', sans-serif;
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

      form {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 70%; 
            margin: 120px auto;
            margin-top: 200px;
            height: 90%;
            text-align: center;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            text-align: left;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 200px;
            padding: 10px;
            align-items: center;
            display: flex;
            justify-content: center;
            margin: 0 auto;
            margin-top: 32px;
        }



        select {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            width: 100%;
            box-sizing: border-box;
        }


        select::-ms-expand {
            display: none;
        }

        select::-webkit-select {
            padding-right: 25px; 
        }

        select option {
            background-color: #fff;
        }
        a {
        display: inline-block;
        padding: 10px 20px;
        background-color:  #BA0001;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        width: 200px;
        align-items: center;
        text-decoration: none;
        }

        a:hover {
            background-color: red;
            text-decoration: none;
            color: white;
        }
        footer {
            background-color: #990f02;
            padding: 10px;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <img src="../images/Batangas_State_Logo.png" alt="logo" width="110px" height="100px">
      
        <a href="adminhomepage.php" class="btn btn-warning ml-auto" style="margin-right: 10px; width: 150px;">
            <i class="bi bi-box-arrow-right"></i> Back
         </a>
</nav>  

       
<body>

<form action="" method="post" enctype="multipart/form-data">

    <h1>Add Item</h1>
    <label for="itemname">Item:</label>
    <input type="text" name="itemname" required><br>

    <label for="item_img">Image:</label>
    <input type="file" name="item_img" accept=".jpg, .jpeg, .png" required>

    <label for="sizes">Size:</label>
        <select name="sizes" required>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L" >L</option>
            <option value="XL">XL</option>
        </select>

    <label for="price">Price:</label>
    <input type="number" name="price" min="0" step="0.01" required><br>

    <button type="submit">Add Item</button>

<?php if(isset($_GET['message'])){
    $message = $_GET['message'];
    ?>

    <div class = "m-5 bg-success text-white" >
        <?php echo $message?>
    </div>
<?php }?>
</form>

</body>
    <footer>
        &copy; Group 2. All Rights Reserved.
    </footer>
</html>
