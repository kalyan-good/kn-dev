<?php include('../config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    
    $insert=mysqli_query($con, "UPDATE $table SET $status_name='$status' WHERE $table_id='$id'");
    
    if($insert){ 
      return true;
     
    }else{
        return false;
    }
}
?>