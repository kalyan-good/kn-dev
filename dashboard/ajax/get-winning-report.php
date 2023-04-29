<?php include('../config.php');

$date = mysqli_real_escape_string($con,$_POST['date']);
$name = mysqli_real_escape_string($con,$_POST['name']);
$session = mysqli_real_escape_string($con,$_POST['market']);


$select_val = mysqli_query($con,"SELECT * FROM user_winning_report WHERE date='$date' AND game_name='$name' AND session='$session'");
    ?>
    <div class="col-12">

			<div class="card">

				<div class="card-body">

					<h4 class="card-title">Winning List
					</h4>

					<div class="table-responsive">

						<table id="resultHistory" class="table table-striped table-bordered">

							<thead> 

								<tr>
								    
                                    <!--<th>User Phone</th>-->
									<th>User Name</th>
                                    <th>Game Name</th>
									<th>Game Type</th>
									<th>Open Pana</th>
									<th>Open Digit</th>
									<th>Close Pana</th>
									<th>Close Digit</th>
									<th>Points</th>
									<th>Amount</th>
									<th>TX Id</th>
                                    <th>TX Date</th>

								</tr>

							</thead>

							<tbody id="result_data">

							<?php 
							if(mysqli_num_rows($select_val) > 0){
						            while($select = mysqli_fetch_array($select_val)){
						                $select_u = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user_info WHERE phone ='$select[username]' "));
    						            ?>
    						                <tr>
    						                   
    						                    <!--<td><?php echo $select['username'];?></td>-->
    						                    <td><a href="view-user.php?id=<?php echo $select_u['id'];?>"><?php echo $select_u['name'];?><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
    						                    <td><?php echo $select['game_name'];?></td>
    						                    <td><?php echo $select['game_type'];?></td>
    						                    <td><?php echo $select['open_pana'];?></td>
    						                    <td><?php echo $select['open_digit'];?></td>
    						                    <td><?php echo $select['close_pana'];?></td>
    						                    <td><?php echo $select['close_digit'];?></td>
    						                    <td><?php echo $select['points_action'];?></td>
    						                    <td><?php echo $select['winning_points'];?></td>
    						                     <td><?php echo $select['bid_id'];?></td>
    						                    <td><?php echo $select['date'];?></td>
    						                   
    						                </tr>
    						            <?php
						            } }
						        ?>

							</tbody>

						</table>

					</div>

				</div>

			</div>

		</div>