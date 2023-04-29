
<?php include('../config.php');

$date = mysqli_real_escape_string($con,$_POST['date']);
$name = mysqli_real_escape_string($con,$_POST['name']);
$type = "all";


    if($type=="all"){
        if($name == "all"){
            $select_array = mysqli_query($con,"SELECT * FROM user_bid_history WHERE date = '$date' ORDER BY id DESC");
        }else{
        $select_array = mysqli_query($con,"SELECT * FROM user_bid_history WHERE game_name = '$name' AND date = '$date' ORDER BY id DESC");}
    }else{
        if($name == "all" ){
            $select_array = mysqli_query($con,"SELECT * FROM user_bid_history WHERE game_type = '$type' AND date = '$date' ORDER BY id DESC");
        }else{
            $select_array = mysqli_query($con,"SELECT * FROM user_bid_history WHERE game_name = '$name' AND game_type = '$type' AND date = '$date' ORDER BY id DESC");
        }
        
    }


if(mysqli_num_rows($select_array) > 0){ ?>
<div class="container-fluid">
	<div class="row row_col">	
		<div class="col-12 col-md-12 col-lg-12">		
			<div class="card">	
				<div class="card-body">
					<h4 class="card-title">Bids List</h4>		
						<div class="dt-ext table-responsive demo-gallery">
						<div id="myTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
						    <div class="row">
						        <div class="col-sm-12 col-md-6"></div>
						        <div class="col-sm-12 col-md-6"></div>
						  </div>
						  <div class="row">
						      <div class="col-sm-12">
				      <table class="table table-striped table-bordered" id="bidList" >
							<thead>						
								<tr role="row">					
									<th class="w-20">Date</th>
									<th>Username</th> 		
									<th>Game Name</th>
									<th>Game Type</th> 
									<th>Session</th>
									<th>Open Pana</th>
									<th>Open Result</th>
									<th>Close Pana</th>
									<th>Close Result</th> 
									<th>Points</th>
								</tr>
							</thead>
							<tbody>
						        <?php 
						            while($select = mysqli_fetch_array($select_array)){
    						            ?>
    						                <tr>
    						                    <td><?php echo $select['date'];?></td>
    						                    <td><?php 
    						                    $select_user = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user_info WHERE phone = '$select[username]'"));
    						                    echo $select_user['name'];
    						                    ?>  <a href="view-user.php?id=<?php echo $select_user['id'];?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
    						                    <td><?php echo $select['game_name'];?></td>
    						                    <td><?php echo $select['game_type'];?></td>
    						                    <td><?php echo $select['session'];?></td>
    						                    <td><?php echo $select['open_pana'];?></td>
    						                    <td><?php echo $select['open_digit'];?></td>
    						                    <td><?php echo $select['close_pana'];?></td>
    						                    <td><?php echo $select['close_digit'];?></td>
    						                    <td><?php echo $select['points_action'];?></td>
    						                </tr>
    						            <?php
						            }
						        ?>
						        </tbody>
						        </table>
						        
					</div>
					</div>
					<div class="row">
					    <div class="col-sm-12 col-md-5"></div>
					    <div class="col-sm-12 col-md-7">
					        <div class="dataTables_paginate paging_simple_numbers" id="myTable_paginate"></div>
					        </div>
					        </div>
					        </div>
					</div>
					<div id="msg"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
   <?php
    
}else{
    echo "No Result Found";
}
?>
						