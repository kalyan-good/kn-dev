<?php 
include('header.php');
include('sidebar.php');?>

<div class="main-content">	<div class="page-content">
<div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Fund Request List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="fundRequestList" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>User Name</th>
                                                <th>Amount</th>
                                                <th>Points</th>
                                                <!--<th>Receipt Image</th>-->
												<th> date</th>
                                                <th>status</th>
                                                <th>Action</th>
                                            </tr>
                                           </thead>
								           <tbody>
									<?php $select_user_fund_request = mysqli_query($con,"SELECT * FROM user_fund_request Order By id Desc");
								            $i = 1;
								            while($select = mysqli_fetch_array($select_user_fund_request)){
								                
								                ?>
								                <tr>
            										<td><?php echo $i;?></td>
            										<td><?php echo $select['username'];?></td>
            										<td><?php echo $select['amount'];?></td>
            										<td><?php echo $select['points'];?></td>
            										<!--<td><?php echo $select['receipe_image'];?></td>-->
            										<td><?php echo $select['date'];?></td>
            										<td><?php if($select['status']=="1"){
                            					        ?><badge class="badge badge-success">Accepted</badge><?php
                            					        }else if($select['status']=="0"){ ?>
                            					            <badge class="badge badge-danger">Pending</badge>
                            					        <?php }else{ ?>
                            					            <badge class="badge badge-danger">Rejected</badge>
                            					        <?php
                            					        }?></td>
                            					        <td><button class="btn btn-success btn-xs accept" onclick="window.location.href = 'status/edit-fund-request.php?id=<?php echo $select['id'];?>';" <?php if(!$select['status']=="0"){echo 'disabled';}?> id="accept">Approve</button>

								<button class="btn btn-danger btn-xs reject" onclick="window.location.href = 'status/edit-fund-request.php?id=<?php echo $select['id'];?>';" <?php if(!$select['status']=="0"){echo 'disabled';}?> id="reject">Reject</button></td>
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
			<script>
			    $(document).ready( function () {
    $('#fundRequestList').DataTable();
} );
			</script>
</div>
</div>
		
	
  <?php include('footer.php');?>