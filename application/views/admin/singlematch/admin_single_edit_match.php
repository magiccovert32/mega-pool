<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($match_details){ ?>
					<h5 class="card-title">Add Match information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="add-match" action="<?php echo base_url('admin-single-update-match'); ?>" method="post">
						<input type="hidden" name="match_id" value="<?php echo $match_details['match_id']; ?>">
						<input type="hidden" name="match_url" value="<?php echo $match_details['match_url']; ?>">

						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="league_id" class="">Select League</label>
									<select name="league_id" id="league_id" class="form-control">
										<option value="">Choose...</option>
										<?php if($league_list){ foreach($league_list as $league){ ?>
											<option <?php if($league['league_id'] == $match_details['league_id']){ echo "selected"; } ?> value="<?php echo $league['league_id']; ?>"><?php echo $league['league_title']; ?></option>
										<?php }} ?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="league_title" class="">Match Date</label>
									<input value="<?php echo @date('Y-m-d', strtotime($match_details['match_date'])); ?>" name="match_date" id="match_date" placeholder="Match date" type="date" class="form-control" required="required" autocomlete="off">
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="league_title" class="">Match Time</label>
									<input value="<?php echo $match_details['match_time']; ?>" name="match_time" id="match_time" placeholder="Match time" type="time" class="form-control" required="required" autocomlete="off">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="position-relative form-group">
									<label for="home_team_id" class="">Where can watch</label>
									<textarea name="where_can_watch" id="where_can_watch" placeholder="Enter where user can see this match" class="form-control"><?php echo $match_details['where_can_watch']; ?></textarea>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="home_team_id" class="">Select Player [<span class="text-info">Select league to populate player</span>]</label>
									<select name="team_id" id="team_id" class="form-control">
										<option value="">Choose...</option>
										<?php if($team_list){ foreach($team_list as $team){ ?>
											<option <?php if($team['team_id'] == $match_details['team_id']){ echo "selected"; } ?> value="<?php echo $team['team_id']; ?>"><?php echo $team['team_title']; ?></option>
										<?php }} ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="home_team_score" class="">Player Point</label>
									<input value="<?php echo $match_details['match_point']; ?>" name="match_point" id="match_point" placeholder="Points if any" type="number" class="form-control" required="required" autocomlete="off">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="highlight_link" class="">Highlights Link</label>
									<input value="<?php echo $match_details['highlight_link']; ?>" name="highlight_link" id="highlight_link" placeholder="Enter highlight link" type="text" class="form-control" autocomlete="off">
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<label for="box_score_link" class="">Box Score Llink</label>
									<input value="<?php echo $match_details['box_score_link']; ?>" name="box_score_link" id="box_score_link" placeholder="Enter box score link" type="text" class="form-control" autocomlete="off">
								</div>
							</div>
						</div>
						
						<button class="mt-1 btn btn-primary" type="submit">Update Match</button>
						<a href="<?php echo  base_url('admin-single-match-management?league_id='.$match_details['league_id']); ?>">
							<button class="mt-1 btn btn-outline-dark ml-3 mr-3" type="button">Cancel</button>
						</a>
						<button class="mt-1 btn btn-danger" type="button" onclick="removeMatch(<?php echo $match_details['match_id']; ?>)">Delete Match</button>
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
				<?php 
					}else{
				?>
					<div class="alert alert-danger fade show mt-10" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">No details found!</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script>
	$('#league_id').on('change', function(){
		let league_id = $('#league_id').val();
		
		$('#team_id').html('');
		
		$.ajax({
            url: base_path+"get-teams-by-league",
            type: "POST",
            data: {league_id:league_id},
            dataType: 'json',
            success: function (response) {
				var home_html = `<option value="">Choose team</option>`;

				if(response.status === 1){
					$.each(response.team_list, function(key,value) {
						home_html += `<option value="`+value.team_id+`">`+value.team_title+`</option>`;
					});
				}
				
				$('#team_id').append(home_html);
				
				if(response.status === 1){
					$.each(response.team_list, function(key,value) {
						away_html += `<option value="`+value.team_id+`">`+value.team_title+`</option>`;
					});
				}				
            }
        });
	});
	
	
	function removeMatch(id){
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to access back.",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: base_path+"admin-single-remove-match",
					type: "POST",
					data: {id:id},
					dataType: 'json',
					success: function (response) {
						if(response.status == 1){
							window.history.back();
						}else{
							swal({
								title: "Error",
								text: response.message,
								icon: "error",
								button: "Close",
							});
						}
					}
				});
			} 
		});
	}
</script>