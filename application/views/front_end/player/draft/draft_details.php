
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	is_currently_selection_team = 0;
</script>
<div class="row">
	<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo  base_url('manage-draft'); ?>">
				<button type="button" class="btn-shadow btn btn-success">
					<span class="btn-icon-wrapper pr-2 opacity-7">
						<i class="pe-7s-angle-left-circle"></i>
					</span>
					Back
				</button>
			</a>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Draft
				</div>
			</div>
			<?php if($draft_details){ ?>
				<input type="hidden" id="draft_url" name="draft_url" value="<?php echo $draft_details['draft_url']; ?>">
				<div class="no-gutters row">
					<div class="col-sm-4 col-md-4 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-left">
								<div class="widget-heading">Draft</div>
								<div class="widget-heading text-success"><?php echo $draft_details['draft_title']; ?></div>
								<div>Starting Date <?php echo @date('Y-m-d H:i:s', strtotime($draft_details['team_selection_ends_on'])); ?></div>
							</div>
						</div>
						<div class="divider m-0 d-md-none d-sm-block"></div>
					</div>
					<div class="col-sm-4 col-md-4 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-left">
								<div class="widget-heading">Time Left</div>
								
								<?php
									$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($draft_details['team_selection_ends_on'])));
									$now 			= new DateTime();
								?>
								
								<?php if($countDownDate < $now){ ?>
									<div class="widget-numbers"><span class="text-danger">Expired</span></div>
									<div class="widget-description text-focus">
										Expired on
										<span class="text-warning pl-1">
											<?php echo $draft_details['team_selection_ends_on']; ?>
										</span>
									</div>
								<?php }else{ ?>
									<div class="widget-numbers"><span id="timer"></span></div>
									<div class="widget-description text-focus">
										Will expire on
										<span class="text-warning pl-1">
											<?php echo $draft_details['team_selection_ends_on']; ?>
										</span>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="divider m-0 d-md-none d-sm-block"></div>
					</div>
					<div class="col-sm-4 col-md-4 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-left">
								<?php
									if($league_details['league_type'] == 2){
								?>
									<div class="widget-heading">Selected Player</div>
								<?php }else{ ?>
									<div class="widget-heading">Selected Team</div>
								<?php } ?>
								<?php if($player_selected_teams){ ?>
									<div class="widget-heading text-success">
										<span>
											<?php
												echo implode(',  ',$player_selected_teams);
											?>
										</span>
									</div>
								<?php }else{ ?> 
									<div class="widget-heading text-danger"><span>Nothing Selected</span></div>
								<?php } ?>
							</div>
						</div>
						<div class="divider m-0 d-md-none d-sm-block"></div>
					</div>
				</div>
			<?php }else{ ?>
				<div class="col-md-12">
					<br/>
					<div class="alert alert-danger fade show" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">You do not have access to view this page.</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		
		<?php if($draft_details){ ?>
			<?php
				$countDownDate 	= new DateTime(@date('Y-m-d h:i:s', strtotime($draft_details['team_selection_ends_on'])));
				$now 			= new DateTime();
			?>
			
			<?php if($countDownDate > $now){ ?>
				<div class="row">
					<?php if($related_team){ ?>
						<?php if($draft_details['team_selection_started'] == 1){ ?>
							<div class="col-md-12">
								<div class="main-card card">
									<div class="card-header-tab card-header">
										<div class="card-header-title font-size-lg text-capitalize font-weight-bold"><h3 class="text-warning">Selection Happening</h3></div>
									</div>
									<div class="card-body">
										<div><b>Selected Teams/Players</b></div>
										<br/>
										<div id="player-selected-block">
											<div id="no-player-selected" style="display: none;">
												<div class="alert alert-info" role="alert">
													All selected players/teams will be displayed here.
												</div>
											</div>
											<div id="already-selected-teams" class="row col-lg-12" style="display: none;">
												
											</div>
										</div>
										<hr/>
										<div><b>Selecte Team/Player</b></div>
										<br/>
										<div id="player-selection-block" style="display: none;">
											<div id="no-available-player" style="display: none;">
												<div class="alert alert-info" role="alert">
													Nothing to select. You have missed your chance.
												</div>
											</div>
											<div id="player-selection-list-box" style="display: none;">
												<div id="player-selection-list" class="col-lg-12 row">
												
												</div>
												<div>
													<div class="btn-pill btn btn-warning" id="submit-team">
														<b>Submit Selection</b>
													</div>
												</div>
											</div>
										</div>
										<div id="player-selection-block-wait" style="display: none;">
											<div class="alert alert-warning" role="alert">
												Another player is on selection. Wait for your turn.
											</div>
										</div>
									</div>				
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-sm-6" >
								<?php
									if($league_details['league_type'] == 2){
								?>
									<div class="card-header-tab card-header">
										<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Players</div>
									</div>
								<?php }else{ ?>
									<div class="card-header-tab card-header">
										<div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Teams</div>
									</div>
								<?php } ?>
								<ul class="todo-list-wrapper list-group list-group-flush" id="league-list" style="max-height: 400px; overflow-y: auto;">
									<?php foreach($related_team as $k => $team){ ?>
										<li class="list-group-item">
											<div class="todo-indicator bg-warning"></div>
											<div class="widget-content p-0">
												<div class="widget-content-wrapper">
													<?php if($draft_details['team_selection_started'] == 1){ ?>
														<div class="widget-content-left mr-2">
															<input type="checkbox" class="selected_team" <?php if($has_record){ if(in_array($team['team_id'],$player_selected_teams_id)){ echo "checked"; }} ?> value="<?php echo $team['team_id']; ?>" name="selected_team[]">
														</div>
													<?php  }?>
													<div class="widget-content-left mr-3">
														<div class="widget-content-left">
															<img width="42" class="rounded" src="<?php echo base_url(); ?>assets/uploads/team_logo/<?php echo $team['team_logo']; ?>" alt="">
														</div>
													</div>
													<div class="widget-content-left">
														<div class="text-dark"><?php echo $team['team_title']; ?></div>
													</div>
												</div>
											</div>
										</li>
									<?php } ?>
								</ul>
								<?php if($draft_details['team_selection_started'] == 1){ ?>
									<!--<div class="d-block text-right card-footer" style="margin-bottom: 50px;">
										<a href="<?php echo  base_url('manage-draft'); ?>"><button class="mr-2 btn btn-link btn-sm">Cancel</button></a>
										<button class="btn btn-primary" id="submit-team">Submit Team</button>
									</div>-->
								<?php } ?>
							</div>
							<div class="col-sm-6" >
								<?php if($draft_details['team_selection_ended'] == 2){ ?>
									<h6><span class="text-danger">You will have <?php echo $draft_details['selection_timing']; ?> minute to confirm your selection.</span></h6>
								<?php } ?>
							</div>
						<?php } ?>
					<?php }else{ ?>
						<div class="col-md-12">
							<br/>
							<div class="alert alert-danger fade show" role="alert">
								<div>
									<strong>Oops</strong>
									<div class="page-title-subheading">You just missed it. All teams already selected.</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>
		<br/>
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details){ ?>
					<h5 class="card-title">Standing Table</h5>
					
					<?php
						if($league_details['league_type'] == 1){
							if($league_team_position){
							if($league_team_count > 0){
					?>
						<table class="mb-0 table table-striped">
							<thead>
								<tr>
									<th>Rank</th>
									<th>Team</th>
									<th class="text-center">Points</th>
									<th class="text-center">Played</th>
									<th class="text-center">Won</th>
									<th class="text-center">Drawn</th>
									<th class="text-center">Lost</th>
									<th class="text-center">Score</th>
								</tr>
							</thead>
							<tbody>
								<?php if($team_score_position){ foreach($team_score_position as $key => $team){ $k = $key+1; ?>
								
									<?php
										if($k < 6){
											$rank_color = '#0ac93d';
										}elseif($k > 5 && $k < 11){
											$rank_color = '#e3c010';
										}elseif($k > 10 && $k < 16){
											$rank_color = '#e36810';
										}elseif($k > 15 && $k < 21){
											$rank_color = '#e67a3c';
										}else{
											$rank_color = '#e31010';
										}
									?>
									<tr>
										<th scope="row" style="color: <?php echo $rank_color; ?>">#<?php echo $k; ?></th>
										<td><img class="img-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$team['team_logo']) ?>" style="width: 50px;height: 50px;margin-right: 10px;"> <?php echo $team['team_title']; ?></td>
										<td class="text-center"><span class="text-success" style="font-weight: 700;"><?php echo $team['total_point']; ?></span></td>
										<td class="text-center"><?php echo $team['play_count']; ?></td>
										<td class="text-center"><?php echo $team['win_count']; ?></td>
										<td class="text-center"><?php echo $team['draw_count']; ?></td>
										<td class="text-center"><?php echo $team['play_count'] - $team['win_count'] - $team['draw_count'] ; ?></td>
										<td class="text-center">
											<span class="text-danger" style="font-weight: 700;">
											<?php
												if($team['play_count'] == 0){
													echo 0;
												}else{
													echo $league_team_position[$key]['score'];
												}
											?>
											</span>
										</td>
									</tr>
								<?php }} ?>
							</tbody>
						</table>
					<?php }else{ ?>
						<div class="alert alert-info fade show mt-10" role="alert">
							<div>
								<strong>Error</strong>
								<div class="page-title-subheading">No team found!</div>
							</div>
						</div>
					<?php }}else{ ?>
						<div class="alert alert-info fade show mt-10" role="alert">
							<div>
								<strong>Error</strong>
								<div class="page-title-subheading">Not yet prepared</div>
							</div>
						</div>
					<?php }}elseif($league_details['league_type'] == 2){ ?>
						<?php
							if($league_team_position){
							if($league_team_count > 0){
						?>
							<table class="mb-0 table table-striped">
								<thead>
									<tr>
										<th>Rank</th>
										<th>Team</th>
										<th class="text-center">Points</th>
										<th class="text-center">Played</th>
										<th class="text-center">Score</th>
									</tr>
								</thead>
								<tbody>
									<?php if($team_score_position){ foreach($team_score_position as $key => $team){ $k = $key+1; ?>
									
										<?php
											if($k < 6){
												$rank_color = '#0ac93d';
											}elseif($k > 5 && $k < 11){
												$rank_color = '#e3c010';
											}elseif($k > 10 && $k < 16){
												$rank_color = '#e36810';
											}elseif($k > 15 && $k < 21){
												$rank_color = '#e67a3c';
											}else{
												$rank_color = '#e31010';
											}
										?>
										<tr>
											<th scope="row" style="color: <?php echo $rank_color; ?>">#<?php echo $k; ?></th>
											<td><img class="img-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$team['team_logo']) ?>" style="width: 30px;height: 30px;margin-right: 10px;"> <?php echo $team['team_title']; ?></td>
											<td class="text-center"><span class="text-success" style="font-weight: 700;"><?php echo $team['total_point']; ?></span></td>
											<td class="text-center"><?php echo $team['play_count']; ?></td>
											<td class="text-center">
												<span class="text-danger" style="font-weight: 700;">
												<?php
													if($team['play_count'] == 0){
														echo 0;
													}else{
														echo $league_team_position[$key]['score'];
													}
												?>
												</span>
											</td>
										</tr>
									<?php }} ?>
								</tbody>
							</table>
						<?php }else{ ?>
							<div class="alert alert-info fade show mt-10" role="alert">
								<div>
									<strong>Error</strong>
									<div class="page-title-subheading">No team found!</div>
								</div>
							</div>
						<?php }}else{ ?>
							<div class="alert alert-info fade show mt-10" role="alert">
								<div>
									<strong>Error</strong>
									<div class="page-title-subheading">Not yet prepared</div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				<?php }else{ ?>
					<div class="alert alert-danger fade show mt-10" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">Invalid league!</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>


<script>
	var countDownDate 	= new Date("<?php echo @date('Y-m-d h:i:s', strtotime($draft_details['team_selection_ends_on'])); ?>").getTime();
	var now 			= new Date("<?php echo @date('Y-m-d h:i:s'); ?>").getTime();
	
	var x = setInterval(function() {		
		var distance 	= countDownDate - now;
		var days 		= Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours 		= Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes 	= Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds 	= Math.floor((distance % (1000 * 60)) / 1000);

		document.getElementById("timer").innerHTML = days + "d " + hours + "h "+ minutes + "m " + seconds + "s ";
		
		if (distance < 1) {
			location.reload();
			clearInterval(x);
			document.getElementById("demo").innerHTML = "EXPIRED";
		}else{
			if(days > 0){
				$('#timer').addClass('text-success');
			}
			else if(days < 1 && hours > 10){
				$('#timer').addClass('text-warning');
			}else if(days < 1 && hours < 5){
				$('#timer').addClass('text-danger');
			}else if(days < 1 && hours < 1){
				$('#timer').addClass('text-danger');
			}
			
			now = now + 1000;
		}		
	}, 1000);
	
	
	$('#submit-team').on('click', function(){
		var selected_team 	= $('.selected_team:checked').val();
		var draft_url 		= $('#draft_url').val();
		
		if(selected_team === "" || selected_team === undefined){
			swal({
				title: "Oops",
				text: 'Please select team',
				icon: "error",
			});
		}else{
			var searchIDs = $("input:radio:checked").map(function(){
								return $(this).val();
							}).get();
									  
			swal({
				title: "Are you sure?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: base_path+"submit-team",
						type: "POST",
						data: {selected_team:searchIDs,draft_url:draft_url},
						dataType: 'json',
						success: function (response) {
							if(response.status == 1){
								swal({
									title: "Success",
									text: response.message,
									icon: "success",
								});
								
								setTimeout(() => {
									location.reload();
								}, 1000);
							}else{
								swal({
									title: "Oops",
									text: response.message,
									icon: "error",
								});
							}
						}
					});
				}
			});
		}
	});
//	var sec     	= <?php echo $draft_details['selection_timing']; ?>*60;
//    var countDiv    = document.getElementById("selection_timer"),
//    secpass,
//    countDown   	= setInterval(function () {
//		'use strict';
//		secpass();
//    }, 1000);
//
//	function secpass() {
//		'use strict';
//		
//		var min     = Math.floor(sec / 60),
//			remSec  = sec % 60;
//		
//		if (remSec < 10) {
//			remSec = '0' + remSec;
//		}
//		
//		if (min < 10) {
//			min = '0' + min;
//		}
//		
//		countDiv.innerHTML = min + ":" + remSec;
//		
//		if (sec > 0) {
//			sec = sec - 1;
//		} else {
//			clearInterval(countDown);
//		}
//	}
</script>

<?php if($draft_details['team_selection_started'] == 1){ ?>
	<script>
		setInterval(function(){
			console.log(is_currently_selection_team);
			if(is_currently_selection_team == 0){
				$.ajax({
					url: base_path+"get-already-selected-players",
					type: "POST",
					data: {draft_id: '<?php echo $draft_details['draft_id']; ?>'},
					dataType: 'json',
					success: function (response) {
						if(response.status === 1){
							$('#no-player-selected').hide();
							
							var teams = response.teams;
							var html  = "";
						
							$.each(teams, function(index, item) {
								html += `
										<div id="`+index+`" class="col-sm-6 col-md-3 mb-2 bg-warning text-center mr-2" style="padding: 5px 10px;">
											<label class="form-check-label"> 
												<span class="text-white">`+item.team_title+`</span>
											</label>
										</div>
										`;
							});
							
							$('#already-selected-teams').html(html);
							$('#already-selected-teams').show();
						}else{
							$('#no-player-selected').show();
							$('#already-selected-teams').hide();
						}
					}
				});
			}
		}, 2000);
		
		setInterval(function(){			
			$.ajax({
				url: base_path+"check-my-selection-time",
				type: "POST",
				data: {draft_id: '<?php echo $draft_details['draft_id']; ?>'},
				dataType: 'json',
				success: function (response) {
					if(response.status === 1){
						if(response.my_turn.turn == 1){
							$('#player-selection-block').show();
							$('#player-selection-block-wait').hide();
							$('#player-selection-list-box').show();
							
							if(is_currently_selection_team === 0){
								displayAvailablePlayerToSelect();
							}
						}else{
							$('#player-selection-block').hide();
							$('#player-selection-block-wait').show();
							$('#player-selection-list-box').hide();
						}
					}else{
						$('#player-selection-block').hide();
						$('#player-selection-block-wait').show();
						$('#player-selection-list-box').hide();
					}
				}
			});			
		}, 2000);
		
		$(document).ready(function(){			
			$.ajax({
				url: base_path+"check-my-selection-time",
				type: "POST",
				data: {draft_id: '<?php echo $draft_details['draft_id']; ?>'},
				dataType: 'json',
				success: function (response) {
					if(response.status === 1){
						if(response.my_turn.turn == 1){
							$('#player-selection-block').show();
							$('#player-selection-block-wait').hide();
							
							if(is_currently_selection_team == 0){
								displayAvailablePlayerToSelect();
							}
						}else{
							$('#player-selection-block').hide();
							$('#player-selection-block-wait').show();
						}
					}else{
						$('#player-selection-block').hide();
						$('#player-selection-block-wait').show();
					}
				}
			});
			
			$.ajax({
				url: base_path+"get-already-selected-players",
				type: "POST",
				data: {draft_id: '<?php echo $draft_details['draft_id']; ?>'},
				dataType: 'json',
				success: function (response) {
					if(response.status === 1){
						$('#no-player-selected').hide();
						
						var teams = response.teams;
						var html  = "";
					
						$.each(teams, function(index, item) {
							html += `
									<div id="`+index+`" class="col-sm-6 col-md-3 mb-2 bg-warning text-center mr-2" style="padding: 5px 10px;">
										<label class="form-check-label"> 
											<span class="text-white">`+item.team_title+`</span>
										</label>
									</div>
									`;
						});
						
						$('#already-selected-teams').html(html);
						$('#already-selected-teams').show();
					}else{
						$('#no-player-selected').show();
						$('#already-selected-teams').hide();
					}
				}
			});
		});
		
		function displayAvailablePlayerToSelect(){
			$.ajax({
				url: base_path+"get-available-teams-to-select",
				type: "POST",
				data: {draft_id: '<?php echo $draft_details['draft_id']; ?>'},
				dataType: 'json',
				success: function (response) {
					if(response.status === 1){
						is_currently_selection_team = 1;
						
						$('#no-available-player').hide();
						
						var teams = response.teams;
						var html  = "";
					
						$.each(teams, function(index, item) {
							html += `
									<div id="`+index+`" class="position-relative form-check bg-success mr-3 mb-3" style="min-width: 100px;padding-right: 5px;">
										<label class="form-check-label">
											&nbsp; <input name="selected_player_id" type="radio" class="form-check-input selected_team" name="selected_team[]" value="`+item.team_id+`"> 
											<span class="text-white">`+item.team_title+`</span>
										</label>
									</div>
									`;
						});
						
						$('#player-selection-list').html(html);					
						$('#player-selection-list-box').show();
					}else{
						is_currently_selection_team = 1;
						
						$('#player-selection-list').html('');		
						$('#no-available-player').show();
						$('#player-selection-list-box').hide();
					}
				}
			});
		}
	</script>
<?php }else{ ?>
	<script>
		setInterval(function(){
			$.ajax({
				url: base_path+"check-draft-selection-timing-by-draft-id",
				type: "POST",
				data: {draft_url: '<?php echo $draft_details['draft_url']; ?>'},
				dataType: 'json',
				success: function (response) {
					if(response.status === 1){
						location.reload();
					}
				}
			});
		}, 2000);
	</script>
<?php } ?>