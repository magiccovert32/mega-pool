<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add Match information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="add-match" action="<?php echo base_url('admin-save-match'); ?>" method="post">
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="league_id" class="">Select League</label>
								<select name="league_id" id="league_id" class="form-control">
									<option value="">Choose...</option>
									<?php if($league_list){ foreach($league_list as $league){ ?>
										<option value="<?php echo $league['league_id']; ?>"><?php echo $league['league_title']; ?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="league_title" class="">Match Date</label>
								<input name="match_date" id="match_date" placeholder="Match date" type="date" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="league_title" class="">Match Time</label>
								<input name="match_time" id="match_time" placeholder="Match time" type="time" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="position-relative form-group">
								<label for="home_team_id" class="">Where can watch</label>
								<textarea name="where_can_watch" id="where_can_watch" placeholder="Enter where user can see this match" class="form-control"></textarea>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="home_team_id" class="">Select Home Team [<span class="text-info">Select league to populate teams</span>]</label>
								<select name="home_team_id" id="home_team_id" class="form-control">
									
								</select>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="away_team_id" class="">Select Away Team [<span class="text-info">Select league to populate teams</span>]</label>
								<select name="away_team_id" id="away_team_id" class="form-control">
									
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="home_team_score" class="">Home Team Score</label>
								<input name="home_team_score" id="home_team_score" placeholder="Home team score if any" type="number" class="form-control" required="required" autocomlete="off" value=0>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="away_team_score" class="">Away Team Score</label>
								<input name="away_team_score" id="away_team_score" placeholder="Away team score if any" type="number" class="form-control" required="required" autocomlete="off" value=0>
							</div>
						</div>
					</div>
					
					<button class="mt-1 btn btn-primary" type="submit">Add match</button>
					<a href="<?php echo  base_url('admin-match-management'); ?>">
						<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
					</a>
				</form>
				
				<?php
					if($this->session->flashdata('league_item')) {
						$message = $this->session->flashdata('league_item');
				?>
					<br/>
					<div class="alert alert-<?php echo $message['class']; ?> fade show mt-10" role="alert">
						<div>
							<strong>Notifications</strong>
							<div class="page-title-subheading"><?php echo $message['message']; ?></div>
						</div>
					</div>
				<?php 
					}
				?>
			</div>
		</div>
	</div>
</div>

<script>
	$('#league_id').on('change', function(){
		let league_id = $('#league_id').val();
		
		$('#home_team_id').html('');
		$('#away_team_id').html('');
		
		$.ajax({
            url: base_path+"get-teams-by-league",
            type: "POST",
            data: {league_id:league_id},
            dataType: 'json',
            success: function (response) {
				var home_html = `<option value="">Choose team</option>`;
				var away_html = `<option value="">Choose team</option>`;

				if(response.status === 1){
					$.each(response.team_list, function(key,value) {
						home_html += `<option value="`+value.team_id+`">`+value.team_title+`</option>`;
					});
				}
				
				$('#home_team_id').append(home_html);
				
				if(response.status === 1){
					$.each(response.team_list, function(key,value) {
						away_html += `<option value="`+value.team_id+`">`+value.team_title+`</option>`;
					});
				}
				
				$('#away_team_id').append(away_html);
            }
        });
	});
</script>