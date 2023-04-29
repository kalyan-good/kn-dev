<?php include('../config.php');

$date = mysqli_real_escape_string($con,$_POST['date']);


$select_user = mysqli_query($con,"SELECT * FROM user_auto_deposite WHERE txt_date  LIKE '%$date%'");
if(mysqli_num_rows($select_user) > 0){
    ?>
    <div class="col-12">

			<div class="card">

				<div class="card-body">

					<h4 class="card-title">Auto Deposit List
					<?php $sum = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(amount) as sum FROM user_auto_deposite WHERE txt_date  LIKE '%$date%'"))?>
					<badge class="btn btn-primary btn-sm btn-float clear_btn">Total Transfer Amount is ₹ <?php echo $sum['sum'];?></badge>
					</h4>

					<div class="dt-ext table-responsive">

						<table id="resultHistory" class="table table-striped table-bordered">

							<thead>
                                            <tr>
                                                <th>S.No.</th>
                                               <th>User Name</th>
                                                <th>Phone Number</th>
                                                <th>Txt Note</th>
                                                <th>Txt Id</th>
                                            	<th>Amount</th>
                                            	<th>Date</th>
                                            	<th>Status</th>
                                            </tr>
                                           </thead>
								           <tbody>
									<?php 
								    
								            $i = 1;
								            while($select = mysqli_fetch_array($select_user)){
								                
								                ?>
								                <tr>
            										<td><?php echo $i;?></td>
            										<td><?php
            										$select_u = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user_info WHERE phone='$select[username]'"));
            										echo $select_u['name'];?>  <a href="view-user.php?id=<?php echo $select_u['id'];?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
            										<td><?php echo $select['username'];?></td>
            										<td><?php echo $select['transaction_note'];?></td>
            										<td><?php echo substr($select['transaction_note'], strpos($select['transaction_note'], "T_ID") + 4);?></td>
            										<td><?php echo strstr($select['transaction_note'], "with", true);?></td>
            										<td><?php echo $select['amount'];?></td>
            										<td><?php echo $select['txt_date'];?></td>
            										<td><?php if($select['status']=="1"){
					        ?><badge class="badge badge-success">Sent</badge><?php
					        }else if($select['status']=="-1"){ ?>
					            <badge class="badge badge-danger">Cancelled</badge>
					        <?php }else{
					        ?>
					            <badge class="badge badge-primary">Pending</badge>
					        <?php
					        } ?></td>
            									</tr>
								                <?php
								                $i++;
								            }
								        
								    ?>
								</tbody>

						</table>

					</div>

				</div>

			</div>

		</div>
    <?php
    
}else{
    echo "No Report Found";
}

?>