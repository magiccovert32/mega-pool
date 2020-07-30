<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add Match information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="add-match" action="<?php echo base_url('admin-single-save-match'); ?>" method="post">
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
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="league_title" class="">Match Date</label>
								<input name="match_date" id="match_date" placeholder="Match date" type="date" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="team_id" class="">Select Player [<span class="text-info">Select league to populate player</span>]</label>
								<select name="team_id" id="team_id" class="form-control">
									
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="match_point" class="">Player Score</label>
								<input name="match_point" id="match_point" placeholder="Player point if any" type="number" class="form-control" required="required" autocomlete="off" value=0>
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
		
		$('#team_id').html('');
		
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
				
				$('#team_id').append(home_html);
            }
        });
	});
</script>