<?php
include("../database/connection.php");

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $sql = "DELETE FROM tbproductinfo WHERE itemid = {$id}";
  $query = mysqli_query($conn,$sql);

  if($query){
    header('location: viewitems.php?message = "deleted successfully"');
  }else{
    echo "ERROR deleting";
  }
}