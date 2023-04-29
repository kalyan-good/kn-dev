<?php include('../dashboard/config.php');
    
    $select_contact_data = mysqli_query($con,"SELECT * FROM contact_detail");
    if(mysqli_num_rows($select_contact_data) > 0){
        
            $check_data_contact = mysqli_fetch_array($select_contact_data);
            
            $data = array(
                'admin_mobile' => $check_data_contact['mobile'],
                'admin_wp' => $check_data_contact['wp_mobile'],
                'admin_telegram' => $check_data_contact['telegram_mobile'],
            );
            $result = array(
                'success' => '1',
                'data' => $data
            );
        
    }else{
        $data = array(
            'msg' => 'Data Not Found!'
        );
        $result = array(
            'success' => '0',
            'data' => $data
        );
    }
    echo json_encode($result);
?>