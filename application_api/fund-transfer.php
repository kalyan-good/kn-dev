<?php include('../dashboard/config.php');


$amount = $_REQUEST['amount'];
$receiver = $_REQUEST['receiver'];
$sender = $_REQUEST['sender'];
$date = date('Y-m-d');
$time = date("H:i:s");


    $check_receiver = mysqli_query($con,"SELECT * FROM user_info WHERE phone='$receiver'");
    $check_sender = mysqli_query($con,"SELECT * FROM user_info WHERE phone='$sender'");
    if(mysqli_num_rows($check_receiver) > 0 && mysqli_num_rows($check_sender) > 0){
        $receiver_detail = mysqli_fetch_array($check_receiver);
        
        $sender_detail = mysqli_fetch_array($check_sender);
        if($receiver_detail['transfer_status'] === '1') {
        //receiver update
        $receiver_wallet = $receiver_detail['wallet'];
        $receiver_amount = $receiver_wallet + $amount;
        $received_amount = "+".$amount;
        $receiver_remark = "Points Transferred By ".$sender_detail['phone'];
        
        //sender update
        $sender_wallet = $sender_detail['wallet'];
        $sender_amount = $sender_wallet - $amount;
        $sended_amount = "-".$amount;
        $sender_remark = "Points Transferred To ".$receiver_detail['phone'];
        
        $update_receiver = mysqli_query($con,"UPDATE user_info SET wallet = '$receiver_amount' WHERE phone='$receiver'");
        $history_receiver = mysqli_query($con,"INSERT INTO `wallet_history`( `status`, `date`, `time`, `amount`, `updated_amount`, `remark`, `phone_number`) VALUES ('1','$date','$time','$received_amount','$receiver_amount','$receiver_remark','$receiver')") ;
        
        $update_sender = mysqli_query($con,"UPDATE user_info SET wallet = '$sender_amount' WHERE phone='$sender'");
        $history_sender = mysqli_query($con,"INSERT INTO `wallet_history`( `status`, `date`, `time`, `amount`, `updated_amount`, `remark`, `phone_number`) VALUES ('1','$date','$time','$sended_amount','$sender_amount','$sender_remark','$sender')") ;
        } else {
            $result = array(
                'success' => '0',
                'msg' => 'You can not transfer point. please contact to admin.'
                );
            echo json_encode($result);
            exit;
        }   
    }
if($history_receiver){
    
   $result = array(
        'success' => '1',
        'msg' => 'Points Transfered Successfully!!'
        );
}
else{
     $result = array(
        'success' => '0',
        'msg' => 'Some Error Occured! Try Again Later!!'
        );
     
}


echo json_encode($result);
?>