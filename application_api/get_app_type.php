<?php include('../dashboard/config.php');

    $select_contact_data = mysqli_query($con,"SELECT * FROM admin_settings");
    if(mysqli_num_rows($select_contact_data) > 0){
        
            $check_data_contact = mysqli_fetch_array($select_contact_data);
            
           $data = array(
                'app' => filter_var($check_data_contact['disable_app'], FILTER_VALIDATE_BOOLEAN),
                'url' => 'https://gooddeedsoftware.com/projects/index.php',
            );
            $result = array(
                'success' => '1',
                'data' => $data
            );
        
    }else{
        $data = array(
             'app' => false,
              'url' => 'https://gooddeedsoftware.com/projects/index.php',
        );
        $result = array(
            'success' => '0',
            'data' => $data
        );
    }
    echo json_encode($result);
?>