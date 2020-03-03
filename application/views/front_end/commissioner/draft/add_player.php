<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($draft_details){ ?>
					<h5 class="card-title">Add Players to Draft <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form method="post" id="add-player-frm">
						<input type="text" style="display: none;" name="draft_url" value="<?php echo $draft_details['draft_url']; ?>">
                        <div class="position-relative form-group">
                            <label for="full_name">Player List</label>
                            <?php
								if($all_megapool_player){
							?>
								<select name="player_id" id="player_id" class="form-control">
									<option value="">Choose player</option>
									<?php
										foreach($all_megapool_player as $player){
									?>
										<option value="<?php echo $player['user_id']; ?>"><?php echo $player['full_name']; ?> - [<?php echo $player['user_email']; ?>]</option>
									<?php } ?>
								</select>
							<?php }else{ ?>
								<div class="alert alert-danger fade show">
									<div class="alert_message">
										No player available to add
									</div>
								</div>
							<?php } ?>
                        </div>
                        <div class="position-relative form-group">
                            <label for="email">Team List</label>
                            <?php
								if($related_team){
							?>
								<select name="team_id" id="team_id" class="form-control">
									<option value="">Choose team</option>
									<?php
										foreach($related_team as $team){
									?>
										<option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_title']; ?></option>
									<?php } ?>
								</select>
							<?php }else{ ?>
								<div class="alert alert-danger fade show">
									<div class="alert_message">
										No team available to add with player
									</div>
								</div>
							<?php } ?>
                        </div>
						<button class="mt-1 btn btn-primary" type="button" id="add-player">Add Player</button>
					</form>
					<br>
                    <div class="alert alert-danger fade show mt-10 display_none" role="alert" id="error-msg">
                        <strong>Error</strong>
                        <div class="alert_message">
                        
                        </div>
                    </div>
                    <div class="alert alert-success fade show mt-10 display_none" role="alert" id="success-msg">
                        <strong>Success</strong>
                        <div class="alert_message">
                        
                        </div>
                    </div>
				<?php }else{ ?>
					<div class="alert alert-danger fade show">
						<strong>Oops</strong>
						<div class="alert_message">
							You don't have access to view this page.
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/commissioner/add_player.js'); ?>" ></script>