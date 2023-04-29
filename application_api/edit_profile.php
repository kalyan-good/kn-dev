<?php 
    include('../dashboard/config.php');
    
    $phone = $_REQUEST['phone_number'];
    $phonepe = $_REQUEST['phonpe'];
    $googlepay = $_REQUEST['gpay'];
    $paytm = $_REQUEST['paytm'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];

    $select = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user_info WHERE phone = '$phone'"));
    
    if($phonepe == ""){
        $phonepe = $select['phonepay'];
    }
    if($googlepay == ""){
        $googlepay = $select['googlepay'];
    }
    if($paytm == ""){
        $paytm = $select['paytm'];
    }
    if($name == ""){
        $name = $select['name'];
    }
    if($paytm == ""){
        $email = $select['email'];
    }

    $update = mysqli_query($con,"UPDATE user_info SET phonepay = '$phonepe', googlepay = '$googlepay', paytm = '$paytm', email = '$email', name = '$name' WHERE phone = '$phone'");
    
    if($update){
   $result = array(
        'success' => '1',
        'msg' => 'Profile update successfully.'
        );
    }
    else{
     $result = array(
        'success' => '0',
        'msg' => 'Some Error Occured! Try Again Later'
        );
     
    }
    echo json_encode($result);
?>