<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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

        table,
        th,
        td {
            border: 1px solid #ddd;
            background-color: #fff;

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

#cardContainer::-webkit-scrollbar {
  width: 10px;  
  height:13px;             /* width of the entire scrollbar */
}

#cardContainer::-webkit-scrollbar-track {
  background: rgba(255,255,255,0.6);        /* color of the tracking area */
  border-radius: 20px;
}

#cardContainer::-webkit-scrollbar-thumb {
  background-color: rgb(179, 0, 0);    /* color of the scroll thumb */
  border-radius: 20px;       /* roundness of the scroll thumb */

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
        style="top: -50px   ; right: 1; z-index: 1; position: fixed; margin: right -50px;">

        <form class="d-flex" method="post">
            <input class="form-control me-2" type="text" placeholder="Enter item name" aria-label="Search"
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

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['btnsearch'])) {

        $search = $_POST['srsearch'];
        //make string print hyphen 

        // echo("<script>console.log(".$id.")</script>");
        //get the id from the search input
    
        $innerSql = "SELECT * FROM `tbproductinfo` WHERE `itemname` LIKE '%" . $search . "%'";
        $innerResult = $conn->query($innerSql);
        if ($innerResult->num_rows > 0) {
            echo "<div id = 'cardContainer'class = '' style = 'width:80%;overflow-x:scroll;overflow-y:hidden;padding:1rem;margin-top:7rem;border-radius:25px;background-color:transparent;backdrop-filter:blur(5px);'> ";
            echo "<div class = 'row flex-nowrap' >";
            while ($row = $innerResult->fetch_assoc()) { 
                $id = $row['itemid'];
                $name = $row['itemname'];
                $itemPIC = $row['item_img'];
                $base64IMG = base64_encode($itemPIC);
                $size = $row['sizes'];
                $price = $row['price'];

                ?>
                <div class="col m-2"
                    style="border-radius:15px;width:19rem;">
                    <div class="card " style="width:18rem;border-radius:25px;height:auto;">
                        <img src="data:image/jpeg;base64,<?=$base64IMG ?>" class="card-img-top" alt="..." style = "width:auto;height:250px;">
                        <div class="card-body" style = "background-color:transparent">
                            <h5 class="card-title"><?php echo $row['itemname']?></h5>
                            <div class = "my-2">
                                <span><i class="bi bi-person-standing-dress"></i><?php echo $row['sizes']?></span><br>
                                <span><i class="bi bi-currency-dollar"></i><?php echo $row['price']?></span><br>
                            </div>

                            <div class = "row row-col-3">
                                <a href="updateitem.php?id=<?=$id ?>&name=<?=$name?>&size=<?=$size?>&price=<?=$price?>" class="btn btn-sm mx-2 btn-success col">Edit</a>
                                <a href="deleteitem.php?id=<?=$id ?>&name=<?=$name?>&size=<?=$size?>&price=<?=$price?>" class="btn btn-sm mx-2 btn-danger col">Delete</a>
                                <?php 
                                    if(isset($_GET['message'])){
                                       $message = $_GET['message'];
                                       $cardid = $_GET['cardid'];
                                       if($id == $cardid)
                                       echo' <a href="#" class="btn btn-sm mx-2 btn-outline-success col" style = "border-radius:25px">'.$message.'</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            echo "</div>";
            echo "</div>";

        } else {
            echo "0 results";
        }

    } else {

        $innerSql = "SELECT * FROM tbproductinfo";
        $innerResult = $conn->query($innerSql);

        if ($innerResult->num_rows > 0) {
            echo "<div id = 'cardContainer'class = '' style = 'width:80%;overflow-x:scroll;overflow-y:hidden;padding:1rem;margin-top:7rem;border-radius:25px;background-color:transparent;backdrop-filter:blur(5px);'> ";
            echo "<div class = 'row flex-nowrap' >";
            while ($row = $innerResult->fetch_assoc()) { 
                $id = $row['itemid'];
                $name = $row['itemname'];
                $itemPIC = $row['item_img'];
                $base64IMG = base64_encode($itemPIC);
                $size = $row['sizes'];
                $price = $row['price'];

                ?>
                <div class="col m-2"
                    style="border-radius:15px;width:19rem;">
                    <div class="card " style="width:18rem;border-radius:25px;height:auto;">
                        <img src="data:image/jpeg;base64,<?=$base64IMG ?>" class="card-img-top" alt="..." style = "width:auto;height:250px;">
                        <div class="card-body" style = "background-color:transparent">
                            <h5 class="card-title"><?php echo $row['itemname']?></h5>
                            <div class = "my-2">
                                <span><i class="bi bi-person-standing-dress"></i><?php echo $row['sizes']?></span><br>
                                <span><i class="bi bi-currency-dollar"></i><?php echo $row['price']?></span><br>
                            </div>

                            <div class = "row row-col-3">
                                <a href="updateitem.php?id=<?=$id ?>&name=<?=$name?>&size=<?=$size?>&price=<?=$price?>" class="btn btn-sm mx-2 btn-success col">Edit</a>
                                <a href="deleteitem.php?id=<?=$id ?>&name=<?=$name?>&size=<?=$size?>&price=<?=$price?>" class="btn btn-sm mx-2 btn-danger col">Delete</a>
                                <?php 
                                    if(isset($_GET['message'])){
                                       $message = $_GET['message'];
                                       $cardid = $_GET['cardid'];
                                       if($id == $cardid)
                                       echo' <a href="#" class="btn btn-sm mx-2 btn-outline-success col" style = "border-radius:25px">'.$message.'</a>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            echo "</div>";
            echo "</div>";

        } else {
            echo "0 results";
        }
    }

    $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
<footer>
    &copy; Group 2. All Rights Reserved.
</footer>

</html>
