<?php include('../config.php');
        $game = mysqli_real_escape_string($con,$_GET['id']);
        $game_name = "";
        $game_name_hindi = "";
        echo "SELECT * FROM games_management WHERE games_name='$game'";
      	$result = mysqli_query($con,"SELECT * FROM games_management WHERE games_name='$game'");
    	$select = mysqli_fetch_array($result);
    	if(!empty($select)) {
        $game_name = $select['games_name'];
        $game_name_hindi = $select['games_name_hindi'];
    	}
?>
<form class="theme-form" id="updateeditgameFrm" name="updateeditgameFrm" method="post" >
			<div class="row">
				<input type="hidden" id="up_game_id" name="game_id" value="">
				<div class="form-group col-12">
					<label>Game Name</label>
					<input type="text" name="game_name" id="up_game_name" class="form-control" placeholder="Enter Game Name" value="<?=$game_name;?>" />
				</div>
				
				<div class="form-group col-12">
					<label for="game_name_hindi">Game Name Hindi</label>
					<input type="text" name="game_name_hindi" id="up_game_name_hindi" class="form-control" value="<?=$game_name_hindi;?>" placeholder="Enter Game Name In Hindi"/>
				</div>
				
				
			               
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="updategameBtn" name="updategameBtn">Update</button>
					
				</div>
			</div>
			<div class="form-group">
				<div id="u_msg"></div>
			</div>
		</form>