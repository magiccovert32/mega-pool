
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
								<?php if($draft_details['team_title']){ ?>
									<div class="widget-heading text-success"><span><?php echo $draft_details['team_title']; ?></span></div>
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
								<?php foreach($related_team as $team){ ?>
									<li class="list-group-item">
										<div class="todo-indicator bg-warning"></div>
										<div class="widget-content p-0">
											<div class="widget-content-wrapper">
												<div class="widget-content-left mr-2">
													<input type="radio" class="selected_team" <?php if($has_record){ if($has_record['team_id'] == $team['team_id']){ echo "checked"; }} ?> value="<?php echo $team['team_id']; ?>" name="selected_team">
												</div>
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
							<div class="d-block text-right card-footer" style="margin-bottom: 50px;">
								<a href="<?php echo  base_url('manage-draft'); ?>"><button class="mr-2 btn btn-link btn-sm">Cancel</button></a>
								<button class="btn btn-primary" id="submit-team">Submit Team</button>
							</div>
						</div>
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
						data: {selected_team:selected_team,draft_url:draft_url},
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
</script>