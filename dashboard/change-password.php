<?php 
include('header.php');
include('sidebar.php');?>

<div class="main-content">	<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-6 col-md-6 mr-auto ml-auto">
				<div class="card">
					
						<h4 class="card-title">Change Password</h4>
							<form class="theme-form" action="action-code/change-password.php" method="post">
						
						<div class="form-group">
							<label for="exampleInputEmail1">Old Password</label>
							<input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Enter Old Password" required>
						</div>
						<div class="form-group">
								<label for="">New Password</label>
								<input name="newpass" class="form-control" id="newpass" type="password" placeholder="Enter New Password" required>
						</div>
						<div class="form-group">
								<label for="">Confirm Password</label>
							   <input class="form-control" name="retypepass" id="retypepass" type="password" placeholder="Enter Confirm Password" required>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary waves-effect waves-light m-t-10" >Update Password</button>
						
						</div>
						<div class="form-group m-b-0">
							 <div id="updatepassmsg"></div>
						</div>
						
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	
<?php include('footer.php');?>