<?php include('../dashboard/config.php');

$phone_number = $_REQUEST['phone_number'];
$amount = $_REQUEST['amount'];
$trans_details = $_REQUEST['trans_detail'];
$date = date('Y-m-d');

$status = '0';
if(isset($_REQUEST['status'])) {
    $status = $_REQUEST['status'];
}
$image = '';
if(isset($_REQUEST['image'])) {
$base64Image = $_REQUEST['image'];
$image = time().'.jpg';
$imageDir = $_SERVER['DOCUMENT_ROOT'] . "/image/";

$filePath = $imageDir . $image;
file_put_contents($filePath,base64_decode($base64Image));
}
$trans = strstr($trans_details,"&",true);
if($trans == 'PHONE_PE') {
    // $status = '0';
}
$transi = str_replace("&&&&"," with T_ID ",$trans_details);

// if($trans == "Other"){
// $sql = "INSERT INTO `user_fund_request`(`username`, `points`, `amount`, `trans_details`, `receipe_image`, `date`, `status`) VALUES ('$phone_number',' ','$amount','$transi','$image','$date','$status')";
// $insert=mysqli_query($con, $sql);
// }else{
$receiver_wallet = 0;
 $check_receiver = mysqli_query($con,"SELECT * FROM user_info WHERE phone='$phone_number'");
    if(mysqli_num_rows($check_receiver) > 0){
        $receiver_detail = mysqli_fetch_array($check_receiver);
        $receiver_wallet = $receiver_detail['wallet'];
    }
$sql = "INSERT INTO `user_fund_request`(`username`, `points`, `amount`, `trans_details`, `receipe_image`, `date`, `status`) VALUES ('$phone_number','$receiver_wallet','$amount','$transi','$image','$date','$status')";
$insert=mysqli_query($con, $sql);

// }

if($insert){
    
    $receiver = $_REQUEST['phone_number'];
    $date = date('Y-m-d');
    $time = date("H:i:s");
    $today = date('Y-m-d h:i:s A');
    $check_receiver = mysqli_query($con,"SELECT * FROM user_info WHERE phone='$receiver'");
    if(mysqli_num_rows($check_receiver) > 0){
        $receiver_detail = mysqli_fetch_array($check_receiver);
        
        //receiver update
        $receiver_wallet = $receiver_detail['wallet'];
        $receiver_amount = $receiver_wallet + $amount;
        $received_amount = "+".$amount;
        $receiver_remark = "Points Added By ".$transi;
        if($status == '1') {
        $update_receiver = mysqli_query($con,"UPDATE user_info SET wallet = '$receiver_amount' WHERE phone='$receiver'");
        $history_receiver = mysqli_query($con,"INSERT INTO `wallet_history`( `status`, `date`, `time`, `amount`, `updated_amount`, `remark`, `phone_number`) VALUES ('1','$date','$time','$received_amount','$receiver_amount','$receiver_remark','$receiver')") ;
        }
        $request_insert = mysqli_query($con,"INSERT INTO `user_auto_deposite`(`username`, `transaction_note`, `amount`, `txt_date`, `status`) VALUES ('$phone_number','$transi','$received_amount','$today','$status')");
    }
   $result = array(
        'success' => '1',
        'msg' => 'Points Added Successfully!!'
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