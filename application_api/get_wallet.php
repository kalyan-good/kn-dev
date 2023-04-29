<?php include('../dashboard/config.php');
    $user = $_REQUEST['phone_number'];

    $select = mysqli_query($con,"SELECT * FROM user_info WHERE phone = '$user'");
    
    $select_admin_data = mysqli_query($con,"SELECT * FROM admin_settings");
    $select_contact_data = mysqli_query($con,"SELECT * FROM contact_detail");
    if(mysqli_num_rows($select) > 0){
        
            $check = mysqli_fetch_array($select);
            $check_data = mysqli_fetch_array($select_admin_data);
            $check_data_contact = mysqli_fetch_array($select_contact_data);
            
            $mobile = $check['phone'];
            $last_seen = date('Y-m-d h:i:s');
            $insert = mysqli_query($con,"UPDATE  user_info SET last_seen = '$last_seen' WHERE phone = '$mobile'");
            $add_fund_status = $check_data['add_fund_status'];
            if($check['betting_status'] === '0' || $check['phone'] === '1234567890') {
                $add_fund_status = 0;
            }
            $data = array(
                'wallet' => $check['wallet'],
                'm_pin' => $check['m_pin'],
                'start_time' => $check_data['market_open_time'],
                'upi_payment_id' => $check_data['upi_payment_id'],
                'upi_name' => $check_data['upi_name'],
                'min_deposite' => $check_data['min_deposite'],
                'max_deposite' => $check_data['max_deposite'],
                'min_withdrawal' => $check_data['min_withdrawal'],
                'max_withdrawal' => $check_data['max_withdrawal'],
                'min_transfer' => $check_data['min_transfer'],
                'max_transfer' => $check_data['max_transfer'],
                'min_limit' => $check_data['min_bid_amt'],
                'max_limit' => $check_data['max_bid_amt'],
                'welcome_bonus' => $check_data['welcome_bonus'],
                'withdraw_open_time' => $check_data['withdraw_open_time'],
                'withdraw_close_time' => $check_data['withdraw_close_time'],
                'Dragon_bonus' => $check_data['Dragon_bonus'],
                'global_batting_status' => $check_data['global_batting_status'],
                'admin_mobile' => $check_data_contact['mobile'],
                'admin_wp' => $check_data_contact['wp_mobile'],
                'admin_telegram' => $check_data_contact['telegram_mobile'],
                'add_fund_status' => $add_fund_status,
            );
            $result = array(
                'success' => '1',
                'data' => $data
            );
        
    }else{
        $data = array(
            'msg' => 'User Not Found!'
        );
        $result = array(
            'success' => '0',
            'data' => $data
        );
    }
    echo json_encode($result);
?>