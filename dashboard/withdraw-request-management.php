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
				  <h4 class="card-title">Withdraw Request List</h4>
					
					  <table class="table table-bordered " id="withdrawRequestList">
						<thead>
						  <tr>
							<th>#</th>
							<th>User Name</th>
							<th>Mobile</th>
							<th>Amount</th>
							<th>Request No.</th>
							<th>Date</th>
							<th>Status</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
					    <?php $select_data = mysqli_query($con,"SELECT * FROM user_withdraw_request ORDER BY id DESC");
					    $i= 1;
					    while($select = mysqli_fetch_array($select_data)){
					        ?>
					        <tr>
					        <td><?php echo $i;?></td>
					        <td><?php $select_user=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM user_info WHERE phone='$select[username]'")); echo $select_user['name']; ?>  <a href="view-user.php?id=<?php echo $select_user['id'];?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
					        <td><?php echo $select['username'];?></td>
					        <td><?php echo $select['points'];?></td>
					        <td><?php echo $select['id'];?></td>
					        <td><?php echo $select['date'];?></td>
					        <td><?php if($select['status']=="1"){
					        ?><badge class="badge badge-success">Accepted</badge><?php
					        }else if($select['status']=="0"){ ?>
					            <badge class="badge badge-danger">Pending</badge>
					        <?php }else{ ?>
					            <badge class="badge badge-danger">Rejected</badge>
					        <?php
					        }?></td>
					        <td>
					            <?php $name = $select_user['name'];
					            $amount = $select['points'];
					            $request_no = $select['id'];
					            $no = $select_user['phone'];
					            $date = $select['date'];
					            $receipe_image = $select['receipe_image'];?>
					        <!--<button class="btn btn-success btn-xs accept" <?php if(!$select['status']=="0"){echo 'disabled';}?> onclick="location.href='action-code/approve-withdraw-request.php?id=<?php echo $select['id'];?>'">Approve</button>-->

							<!--<button class="btn btn-danger btn-xs reject" <?php if(!$select['status']=="0"){echo 'disabled';}?> onclick="location.href='action-code/reject-withdraw-request.php?id=<?php echo $select['id'];?>'">Reject</button>-->
							<!--<a onclick="return confirm('Are you sure you want to delete?')" href="delete/delete-withdraw-request.php?id=<?php echo $select['id'];?>"><button class="btn btn-danger btn-xs">Delete</button></a>-->
						    <button class="btn btn-success btn-xs accept" <?php if(!$select['status']=="0"){echo 'disabled';}?> id="accept" data-id="<?php echo $select['id'];?>" data-user_name="<?php echo $name;?>" data-mobile="<?php echo $no;?>" data-request_amount="<?php echo $amount;?>" data-request_number="<?php echo $request_no;?>" data-date="<?php echo $date;?>">Approve</button>
							<a id="newModal" data-toggle="modal" data-id="<?php echo $select['id'];?>" data-target="#myModal" data-name="<?php echo $name;?>" data-amount="<?php echo $amount;?>" data-request="<?php echo $request_no;?>" data-no="<?php echo $no;?>" data-date="<?php echo $date;?>" data-recipt="/game-admin/uploads/image/receipt/<?=$receipe_image?>"><span class="badge badge-rounded badge-outline-primary"><i class="mdi mdi-eye font-size-18"></i></span></a>
							<button class="btn btn-danger btn-xs reject" <?php if(!$select['status']=="0"){echo 'disabled';}?> id="reject" data-toggle="modal" data-target="#requestRejectModel" data-id="<?php echo $select['id'];?>">Reject</button>
											
							</td>
										
					        </tr>
					        <?php
					        $i++;
					    }
					    ?>
					</tbody>
						</table>
					
						<div id="msg"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	var valid = {
			 

			ajaxError:function(jqXHR,exception) {
				var msg = '';
				if (jqXHR.status === 0) {
					msg = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
					msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
					msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
					msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
					msg = 'Time out error.';
				} else if (exception === 'abort') {
					msg = 'Ajax request aborted.';
				} else {
					msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				return msg;
			},
			
		    validateExtension:function(val,type) {
				if(type==1)
					var re = /(\.jpeg|\.jpg|\.png)$/i;
				else if(type==2)
					var re = /(\.jpeg|\.jpg|\.png\.pdf|\.doc|\.xml|\.docx|\.PDF|\.DOC|\.XML|\.DOCX|\.xls|\.xlsx)$/i;
				else if(type==3)
					var re = /(\.pdf|\.docx|\.PDF|\.DOC|\.DOCX)$/i;
				return re.test(val)
			},
			snackbar:function(msg) {
				$("#snackbar").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			snackbar2:function(msg) {
				 $("#snackbar").html(msg).fadeIn('slow');
			},
			snackbar_info:function(msg) {
				$("#snackbar-info").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			snackbar_error:function(msg) {
				$("#snackbar-error").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			snackbar_success:function(msg) {
				$("#snackbar-success").html(msg).fadeIn('slow').delay(3000).fadeOut('slow');
			},
			error:function(msg) {
				return "<p class='alert alert-danger'><strong>Error : </strong> "+msg+"</p>";
			},
			success:function(msg) {
				return "<p class='alert alert-success'>"+msg+"</p>";
			},
			info:function(msg) {
				return "<p class='alert alert-info'>"+msg+"</p>";
			}
	};
	
	$(document).on("click", "#newModal", function () {
     var name = $(this).data('name');
      var  amount = $(this).data('amount');
      var request = $(this).data('request');
      var no = $(this).data('no'); 
      var date = $(this).data('date');
      var recipt = $(this).data('recipt');
     $(".modal-body #Name").html( name );
     $(".modal-body #Amount").html( amount );
     $(".modal-body #Request").html( request );$(".modal-body #No").html( no );
     $(".modal-body #Date").html( date );
     $(".modal-body #Recipt").attr('src', recipt );
});
	  $(document).on('click', '.accept', function(e) {
		var withdraw_request_id = $(this).attr('data-id');
		var user_name = $(this).attr('data-user_name');
		var mobile = $(this).attr('data-mobile');
		var request_amount = $(this).attr('data-request_amount');
		var request_number = $(this).attr('data-request_number');
		$(".user_info").html('<table  class="table table-striped table-bordered "><tr><td>User Name</td><td>'+user_name+'</td></tr><tr><td>Mobile</td><td>'+mobile+'</td></tr><tr><td>Request Number</td><td>'+request_number+'</td></tr><td>Request Amount</td><td>'+request_amount+'</td></tr></table>');
		
		$("#withdraw_req_id").val(withdraw_request_id);
		$('#requestApproveModel').modal('show');
    });
	
	$(document).on('click', '#reject', function(e) {
		var withdraw_request_id = $(this).attr('data-id');
		$("#r_withdraw_req_id").val(withdraw_request_id);
		$('#requestRejectModel').modal('show');
    });
    $(document).on('submit', '#withdrawapproveFrm', function(e){
		$("#submitBtn").attr("disabled",true);	   
		var changeBtn = $("#submitBtn").html();
		$("#submitBtn").html("Submitting..");
			$.ajax({ 
				url: 'action-code/approve-withdraw-request.php',
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				dataType: "json",
				success: function (data)
				{	
					if(data.status == "success") 
					{
						$('#alert_msg_manager').html(data.msg).fadeIn('slow').delay(2000).fadeOut('slow');
						$("#status").html('<badge class="badge badge-success">'+data.request_status+'</badge>');
						$("#accept").attr("disabled",true);	
						$("#reject").attr("disabled",true);
						location.reload();
						window.setTimeout(function(){$('#requestApproveModel').modal('hide')}, 1000);
					}else{
						$("#alert_msg_manager").html(data.msg);
						$("#alert_msg_manager").fadeIn('slow').delay(2500).fadeOut('slow');
						$("#submitBtn").attr("disabled",false);
						$("#submitBtn").html(changeBtn);
					}
					
				},
				error: function (jqXHR, exception) {
						var msg = valid.ajaxError(jqXHR,exception);
						$("#alert_msg_manager").html(valid.error(msg)).fadeIn('slow').delay(5000).fadeOut('slow');
						$("#submitBtn").attr("disabled",false);
						$("#submitBtn").html(changeBtn);
				}
			});
        e.preventDefault();	
    });
	
	$(document).on('submit', '#withdrawRejectFrm', function(e){
		$("#submitBtnReject").attr("disabled",true);	   
		var changeBtn = $("#submitBtnReject").html();
		$("#submitBtnReject").html("Submitting..");
			$.ajax({ 
				url: 'action-code/reject-withdraw-request.php',
				type: 'POST',
				data: new FormData( this ),
				processData: false,
				contentType: false,
				dataType: "json",
				success: function (data)
				{	
					if(data.status == "success") 
					{
						$('#alert_msg').html(data.msg).fadeIn('slow').delay(2000).fadeOut('slow');
						$("#status").html('<badge class="badge badge-success">'+data.request_status+'</badge>');
						$("#accept").attr("disabled",true);	
						$("#reject").attr("disabled",true);	
						location.reload();
						window.setTimeout(function(){$('#requestRejectModel').modal('hide')}, 1000);
					}else{
						$("#alert_msg").html(data.msg);
						$("#alert_msg").fadeIn('slow').delay(2500).fadeOut('slow');
						$("#submitBtnReject").attr("disabled",false);
						$("#submitBtnReject").html(changeBtn);
					}
					
				},
				error: function (jqXHR, exception) {
						var msg = valid.ajaxError(jqXHR,exception);
						$("#alert_msg").html(valid.error(msg)).fadeIn('slow').delay(5000).fadeOut('slow');
						$("#submitBtnReject").attr("disabled",false);
						$("#submitBtnReject").html(changeBtn);
				}
			});
        e.preventDefault();	
    });
	
	function validateImageExtensionOther(val,id_name)
{
	if(id_name==1)
		var fileUpload = document.getElementById("file");
	if(id_name==2)
		var fileUpload = document.getElementById("subcategory_icon");
	if(id_name==3)
		var fileUpload = document.getElementById("sub_subcategory_icon");
	if(id_name==4)
		var fileUpload = document.getElementById("child_sub_subcategory_icon");
	if(id_name==5)
		var fileUpload = document.getElementById("product_cover_image");



	if(!valid.validateExtension(val,1) && id_name==1) 
    {            
		valid.snackbar('Invalid file type (only .jpeg,.jpg,.png allowed)');
		$('#file').val('');
		return false;
    }else if(!valid.validateExtension(val,3) && id_name==3)
	{
		valid.snackbar('Invalid file type (only .Pdf,.doc,.docx allowed)');
		$('#attachment').val('');
		return false;
	}
 
        //Check whether HTML5 is supported.
       else if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
   
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
					var file = fileUpload.files[0];//get file   
					var sizeKB = file.size / 1024;
                    var height = this.height;
                    var width = this.width;
    //                 if (height > 256 || width > 256) {
				// 		valid.snackbar('Height and Width must not exceed 256px.');
				// 		$("#category_icon").val('');
				// 		$("#subcategory_icon").val('');
				// 		$("#sub_subcategory_icon").val('');
    //                     return false;
    //                 }
					
				// 	if(sizeKB>30)
				// 	{
				// 		valid.snackbar('Icon size must not exceed 30Kb.');
				// 		$("#category_icon").val('');
				// 		$("#subcategory_icon").val('');
				// 		$("#sub_subcategory_icon").val('');
    //                     return false;
				// 	}
					
						$("#submitBtn").attr("disabled",false);
					
                    return true;
                };
 
            }
        }  
}	

			

function validExtension(val,type)
{
	if(!valid.validateExtension(val,type)) 
    {            
		valid.snackbar('Invalid file type (only .jpeg,.jpg,.png allowed)');
		$(".uimg").val(''); 
		return false;
    }
}
	</script>
	<script>
			    $(document).ready( function () {
    $('#withdrawRequestList').DataTable();
} );
			</script>
</div>






  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4 class="modal-title">Withdraw Request Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <table id="withdrawreqtable" class="table table-bordered table-striped">
	<thead>						
		<tr>					
			<th class="w-25">Name</th>
			<th>Details</th> 		
			<th class="w-25">Name</th>
			<th>Details</th> 			
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td>User Name</td>
			<td><span id="Name"></span></td>
			<td>Request Amount</td>
			<td><span id="Amount"></span>
			</td>
		</tr>
		<tr>
			<td>Request Number</td>
			<td><span id="Request"></span></td>
			<td>Payment Method</td>
			<td><badge class="badge badge-pill badge-soft-info">UPI Transfer</badge></td>
		</tr>
						<tr>
			<td>UPI Number</td>
			<td><span id="No"></span></td>
			<td>Request Date</td>
			<td><span id="Date"></span></td>
		</tr>
				<tr>
			<td>Request Accept Date</td>
			<td>N/A</td>
			<td>Remark</td>
			<td></td>
		</tr>
		<tr>
			<td>Payment Receipt</td>
			<td><img src="" id="Recipt" style="height: 120px;"></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	
<?php include('footer.php');?>