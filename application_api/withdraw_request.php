<?php include('../dashboard/config.php');

$phone_number = $_REQUEST['phone_number'];
$points = $_REQUEST['amount'];
$remark = $_REQUEST['remark'];
$date = date('Y-m-d');

$limits = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM admin_settings"));

$min_limit = $limits['min_withdrawal'];
$max_limit = $limits['max_withdrawal'];
$withdraw_open_time = $limits['withdraw_open_time'];
$withdraw_close_time = $limits['withdraw_close_time'];
if(time() >= strtotime($withdraw_open_time) && time() <= strtotime($withdraw_close_time)) {
if($points <= $max_limit && $points >= $min_limit){
 
$sql = "INSERT INTO `user_withdraw_request`(`username`, `points`, `amount`,  `receipe_image`, `date`, `remark`, `status`) VALUES ('$phone_number','$points',' ','','$date','$remark','0')";
$insert=mysqli_query($con, $sql);
if($insert){
    $select_user = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `user_info` WHERE `phone` = '$phone_number'"));
    $wallet = $select_user['wallet'];
    $updated_amount = $wallet - $points;
         
     $deduct_amount = mysqli_query($con,"UPDATE `user_info` SET `wallet`='$updated_amount' WHERE `phone` = '$phone_number'");
     
   $result = array(
        'success' => '1',
        'msg' => 'Withdraw Request Added Successfully!!'
        );
}
else{
     $result = array(
        'success' => '0',
        'msg' => 'Some Error Occured! Try Again Later!!'
        );
     
}

}else{
    $result = array(
        'success' => '0',
        'msg' => 'Limit does not match!! Minimum Limit is '.$min_limit.' & Maximum Limit is '.$max_limit
        );
}
}else{
    $result = array(
        'success' => '0',
        'msg' => 'Withdraw time is closed!! Withdraw open time is '.$withdraw_open_time.' & Withdraw close time is '.$withdraw_close_time
        );
}
echo json_encode($result);
?>