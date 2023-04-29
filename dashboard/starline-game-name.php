<?php 
include('header.php');
include('sidebar.php');?>

<div class="main-content">	<div class="page-content">
<div class="container-fluid">
	<div class="row">
	<!-- Zero Configuration  Starts-->	
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
			  <h4 class="card-title d-flex align-items-center justify-content-between">Starline Game Name List			  <a class="btn btn-primary btn-sm btn-float" href="#addstarlinegameModal" role="button" data-toggle="modal">Add Game </a></h4>
				  <table class="table table-striped table-bordered" id="starlinegameList">
					<thead>
					  <tr>
						<th>#</th>
						<th>Game Name</th>
						<th>Game Name Hindi</th>
						<th>Open Time</th>
						<th>Status</th>
						<th>Market Status</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody>
									<?php 
									$day = date('l');
									$select_starline_game_name = mysqli_query($con,"SELECT * FROM starline_game_name ORDER BY STR_TO_DATE(open_time, '%l:%i %p' ) ASC");
								    if($select_starline_game_name){
								        if(mysqli_num_rows($select_starline_game_name)>0){
								            $i = 1;
								            while($select = mysqli_fetch_array($select_starline_game_name)){
								                
								                ?>
								                <tr>
            										<td><?php echo $i;?></td>
            										<td><?php echo $select['games_name'];?></td>
            										<td><?php echo $select['games_name_hindi'];?></td>
            										<td><?php echo $select['open_time'];?></td>
            										<td><a href="status/edit-starline-game.php?id=<?php echo $select['id'];?>"><?php if($select['game_status']==='0'){
            										    ?><span class="badge badge-pill badge-soft-danger font-size-12">NO</span><?php
            										}else{ ?><span class="badge badge-pill badge-soft-success font-size-12">YES</span><?php }?></a></td>
            										<td><?php 
            										$current_time = strtotime(date('h:i a'));
            										$open_time = strtotime($select['open_time']);
            										$start = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM admin_settings"));
            										$start_time = strtotime($start['market_open_time']);
            										if($current_time < $start_time OR ($current_time > $open_time) OR $select['game_status']=="0"){
            										    ?><span class="badge badge-pill badge-soft-danger font-size-12">Market Closed</span><?php
            										}else{ ?><span class="badge badge-pill badge-soft-success font-size-12">Market Running</span><?php }?></td>
            										<td>
            											<div class="edit-icon-css">
            										    	<a href="edit-game-name.php?id=<?php echo $select['id'];?>"><span class="btn btn-primary btn-xs mr-1">EDIT</span></a>
            												<a href="javascript:void(0);" title="Market Close" class="success openCloseMarket" href="" id="success-<?php echo $select['id'];?>-starline_game_name-id-market_status"><button class="btn btn-success btn-xs mr-1" type="button" title="Market Close" fdprocessedid="w9eqe">Market Close</button></a>
            												<!--<a onclick="return confirm('Are you sure you want to delete?')" href="delete/delete-starline-game.php?id=<?php echo $select['id'];?>"><span class="btn btn-danger btn-xs mr-1">DELETE</span></a>-->
            											</div>
										            </td>
            									</tr>
								                <?php
								                $i++;
								            }
								        }else{
								            ?>
								            <tr>
            									<td colspan="8">No Data Added!</td>
            								</tr>
								            <?php    
								        }
								    }else{
								        ?>
								            <tr>
            									<td colspan="8">No Data Found!</td>
            								</tr>
								        <?php
								    }
								    ?>
								</tbody>
					</table>
				 
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="addstarlinegameModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Add Game</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body">
		<form method="POST" action="action-code/add-starline-game.php">
			<div class="row">
				<input type="hidden" name="game_id" value="">
				<div class="form-group col-12">
					<label for="game_name">Game Name</label>
					<input type="text" name="game_name" id="game_name" class="form-control" placeholder="Enter Game Name"/>
				</div>
				
				<div class="form-group col-12">
					<label for="game_name_hindi">Game Name Hindi</label>
					<input type="text" name="game_name_hindi" id="game_name_hindi" class="form-control" placeholder="Enter Game Name In Hindi"/>
				</div>
				<div class="row col-12">
				<div class="form-group col-6">
                            <label  for="open_time">Open Time</label>
                              <input name="open_time" id="open_time" class="form-control digits" type="time" value="">
                            
                </div>
                             </div>
				
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>
					<button type="reset" class="btn btn-danger waves-light m-t-10">Reset</button>
				
				</div>
			</div>
			<div class="form-group">
				<div id="msg"></div>
			</div>
		</form>
	</div>
	</div>
  </div>
</div>

<div class="modal fade" id="updategameModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Update Game</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body modal_update_game_body">
</div>
</div>
</div>
</div>



<div class="modal fade" id="starlineoffdayModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-xl-4">
	  <div class="modal-header">
		<h5 class="modal-title">Market Off Day</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body starline_modal_off_day">
</div>
</div>
</div>
<script>
    $(document).ready( function () {
    $('#starlinegameList').DataTable();
} );
	$(document).on('click', '.openCloseMarket', function(e){
		var id = $(this).attr('id');
        var myArray = id.split('-');
		var table_id=myArray[3];
		
        $.ajax({
            type: "POST",
            url:  'edit/update-market-status.php',
            data: 'id=' + myArray[1]+"&table="+myArray[2]+"&table_id="+table_id+"&status_name="+myArray[4]+"&status=0",
             success: function(data) 
                {	
		
				
				if(myArray[0]=='danger')
                {
                    $("#"+id).html('<button class="btn btn-outline-success btn-xs m-l-5" type="button" title="Inactivate">Inactivate</button>');
					$("#status_show"+myArray[1]).html('<badge class="badge badge-success">Active</badge>');
                   $("#"+id).attr('id','success-'+myArray[1]+'-'+myArray[2]+'-'+table_id+'-'+myArray[4]);
                }
                else
                {
					$("#"+id).html('<button class="btn btn-outline-danger btn-xs m-l-5" type="button" title="Activate">Activate</button>');
					$("#status_show"+myArray[1]).html('<badge class="badge badge-danger">Inactive</badge>');
					$("#"+id).attr('id','danger-'+myArray[1]+'-'+myArray[2]+'-'+table_id+'-'+myArray[4]);
                }
                $("#msg").html(data);
                $("#msg").fadeIn('slow').delay(5000).fadeOut('slow');
            },
			error: function (jqXHR, exception) {
					var msg = valid.ajaxError(jqXHR,exception);
					$("#msg").html(valid.error(msg)).fadeIn('slow').delay(5000).fadeOut('slow');
					
				}
        });
		
		e.preventDefault();	
    }); 
</script>
</div>
	
<?php include('footer.php');?>