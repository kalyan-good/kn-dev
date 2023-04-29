<?php include('../config.php');
     $id = mysqli_real_escape_string($con,$_POST['withdraw_req_id']);
     $remark = '';
     if(isset($_POST['remark']))
     $remark = mysqli_real_escape_string($con,$_POST['remark']);
     $date = date('Y-m-d');
     $time = date("h:i:sa");
     
     $select_request = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `user_withdraw_request` WHERE `id` = '$id'"));
     
     $phone_number = $select_request['username'];
     
     $amount = $select_request['points'];
     
     $select_user = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `user_info` WHERE `phone` = '$phone_number'"));
     
     $wallet = $select_user['wallet'];
     
     $updated_amount = $wallet - $amount;
     
     
     $receipt = "";
     if($updated_amount >= 0){
     if($_FILES){
     if(!$_FILES['file']['name']){
         
         $receipt = "";
     }else{
         
         $loc = $_SERVER['DOCUMENT_ROOT']."/game-admin/uploads/image/receipt/";
         $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
         $receipt = time()."-receipt.".$ext;
         $file_path = $loc;
         if (!file_exists($file_path)) {
                // Create a new file or direcotry
                mkdir($file_path, 0777, true);
            }
         move_uploaded_file($_FILES['file']['tmp_name'],$loc.$receipt);
     }
     }
     $wallet_remark = $amount . "₹ Transferred to your Account!";
     
     $am = "-".$amount;
     
     //$deduct_amount = mysqli_query($con,"UPDATE `user_info` SET `wallet`='$updated_amount' WHERE `phone` = '$phone_number'");
     
     $transaction = mysqli_query($con,"INSERT INTO `wallet_history`(`status`, `date`, `time`, `amount`, `updated_amount`, `remark`, `phone_number`) VALUES ('1','$date','$time','$am','$updated_amount','$wallet_remark','$phone_number')");
     
     $update_status = mysqli_query($con,"UPDATE `user_withdraw_request` SET `receipe_image`='$receipt',`remark`='$remark',`status`='1' WHERE id = '$id'");
     
     if($update_status){
    
   $result = array(
        'status' => 'success',
        'msg' => 'Withdraw Successfully!!'
        );
} }
else{
     $result = array(
        'status' => 'error',
        'msg' => 'This user not have enough balance in the wallet please check.'
        );
     
}
echo json_encode($result);
?>