<?php
include('../config.php');

$id = $_GET['id']; 
$select = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM result_chart WHERE id = '$id'"));
$game_name = $select['game_name'];
$close_pana = $select['close_panna'];
$close_digit = $select['close_digit'];
$date = date('Y-m-d');
$select_win = mysqli_query($con,"SELECT * FROM user_winning_report WHERE game_name='".$game_name."' AND date='".$date."' AND (close_pana ='$close_pana' OR close_digit='$close_digit')");
while($sel = mysqli_fetch_array($select_win)){
$username = $sel['username'];
$amount = $sel['winning_points'];
$receiver = $username;

$time = date("H:i:s");


    $check_receiver = mysqli_query($con,"SELECT * FROM user_info WHERE phone='$username'");
    if(mysqli_num_rows($check_receiver) > 0){
        $receiver_detail = mysqli_fetch_array($check_receiver);
        
        //receiver update
        $receiver_wallet = $receiver_detail['wallet'];
        $receiver_amount = $receiver_wallet - $amount;
        $received_amount = "-".$amount;
        $receiver_remark = "Points Deducted By Admin due to result change";
        $update_receiver = mysqli_query($con,"UPDATE user_info SET wallet = '$receiver_amount' WHERE phone='$receiver'");
       // $history_receiver = mysqli_query($con,"INSERT INTO `wallet_history`( `status`, `date`, `time`, `amount`, `updated_amount`, `remark`, `phone_number`) VALUES ('1','$date','$time','$received_amount','$receiver_amount','$receiver_remark','$receiver')") ;
        $delete_wallet = mysqli_query($con,"DELETE FROM wallet_history WHERE date = '$date' AND amount = '$amount' AND phone_number = '$receiver'");
    }
    $delete_win =  mysqli_query($con,"DELETE FROM user_winning_report WHERE game_name='".$game_name."' AND date='".$date."'  AND (close_pana ='$close_pana' OR close_digit='$close_digit')");
}
   $delete = mysqli_query($con,"UPDATE result_chart set close_panna ='', close_digit='' WHERE id='".$id."'");
?>
<script>
window.location ="../index.php";
</script>