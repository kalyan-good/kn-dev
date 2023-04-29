<?php include('../config.php');
    $id = mysqli_real_escape_string($con,$_POST['withdraw_req_id']);
    $remark = '';
    if(isset($_POST['remark']))
    $remark = mysqli_real_escape_string($con,$_POST['remark']);
    
    $update = mysqli_query($con,"UPDATE user_withdraw_request SET status = '-1', remark = '$remark' WHERE id='$id'");
    
     if($update){
        $select_request = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `user_withdraw_request` WHERE `id` = '$id'"));
     
        $phone_number = $select_request['username'];
        $select_user = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `user_info` WHERE `phone` = '$phone_number'"));
        $wallet = $select_user['wallet'];
        $updated_amount = $wallet + $select_request['points'];
         
        $deduct_amount = mysqli_query($con,"UPDATE `user_info` SET `wallet`='$updated_amount' WHERE `phone` = '$phone_number'");
     
   $result = array(
        'status' => 'success',
        'msg' => 'Withdraw Rejected Successfully!!'
        );
} 
else{
     $result = array(
        'status' => 'error',
        'msg' => 'Some Error Occured! Try Again Later!!'
        );
     
}
echo json_encode($result);
?>