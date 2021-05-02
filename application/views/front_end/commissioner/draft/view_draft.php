<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details && $draft_details){ ?>
				
					<div class="no-gutters">
						<div class="no-gutters row">
							<div class="col-md-3 col-xl-3">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading text-success">
												<?php echo $draft_details['draft_title']; ?>
											</div>
											<?php
												if($draft_details['draft_status'] == 1){
													$status_class="success";
													$status_text = "Active";
												}elseif($draft_details['draft_status'] == 2){
													$status_class="warning";
													$status_text = "In-active";
												}elseif($draft_details['draft_status'] == 3){
													$status_class="danger";
													$status_text = "Removed";
												}elseif($draft_details['draft_status'] == 4){
													$status_class="success";
													$status_text = "Published";
												}
											?>
											<div class="widget-subheading">
												<div class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3 col-xl-3">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading text-info">Selected League</div>
											<small><?php echo $draft_details['league_title']; ?></small>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3 col-xl-3">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading text-warning">Megapool</div>
											<small><?php echo $draft_details['mega_pool_title']; ?></small>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3 col-xl-3">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading text-warning">Player Joined</div>
											<small><?php echo $player_joined; ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr/>
						<div class="no-gutters row">
							<div class="col-md-2 col-xl-2">
								<div class="widget-content-right">
									<a class="widget-content-left ml-0" href="<?php echo base_url('my-draft') ?>">
										<div class=" btn-pill btn btn-outline-dark">Back to Draft</div>
									</a>
								</div>
							</div>
							
							<?php
								$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($draft_details['team_selection_ends_on'])));
								$now 			= new DateTime(@date('Y-m-d H:i:s'));
							?>
							
							<?php
								if($countDownDate > $now){
							?>
								<?php if($draft_details['team_selection_started'] == 2 && $draft_details['team_selection_ended'] == 2){ ?>
									<div class="col-md-2 col-xl-2">
										<div class="widget-content-right">
											<div class=" btn-pill btn btn-warning" id="start-selection">Start Selection</div>
										</div>
									</div>
								<?php } ?>
								
								<?php if($draft_details['team_selection_started'] == 1 && $draft_details['team_selection_ended'] == 2){ ?>
									<div class="col-md-2 col-xl-2">
										<div class="widget-content-right">
											<div class=" btn-pill btn btn-success">Selection Started</div>
										</div>
									</div>
								<?php } ?>
								
								<?php if($draft_details['team_selection_started'] == 2 && $draft_details['team_selection_ended'] == 1){ ?>
									<div class="col-md-2 col-xl-2">
										<div class="widget-content-right">
											<div class=" btn-pill btn btn-danger">Selection Ended</div>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>					
				<?php }else{ ?>
					<div class="alert alert-danger fade show">
							<strong>Notification</strong>
							<div class="alert_message">
								You don't have access to view this page.
							</div>
						</div>
				<?php } ?>
			</div>
		</div>
		
		<?php if($league_details && $draft_details){ ?>
			<div class="position-relative form-group">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal mb-3">
					Associated Teams
				</div>
				<div class="row">
					<div class="col-sm-12" style="max-height: 400px; overflow-y: auto;">
						<ul class="todo-list-wrapper list-group list-group-flush" id="league-list">
							 <?php if($team_list){ foreach($team_list as $team){ ?>
								<li class="list-group-item">
									<div class="todo-indicator bg-warning"></div>
									<div class="widget-content p-0">
										<div class="widget-content-wrapper">
											<div class="widget-content-left mr-3">
												<div class="widget-content-left">
													<img width="42" class="rounded" src="<?php echo base_url('assets/uploads/team_logo/'.$team['team_logo']) ?>" alt="">
												</div>
											</div>
											<div class="widget-content-left">
												<div class="text-dark"><?php echo $team['team_title']; ?></div>
												
												<?php
													if(in_array($team['team_id'],$selected_team_ids)){
												?>
													<div class="badge badge-success">Selected</div>
												<?php 
													}else{
												?>
													<div class="badge badge-warning">Not Selected</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</li>
							<?php }}else{ ?>
								<div class="alert alert-danger fade show" role="alert">
									<div>
										<strong>Oops</strong>
										<div class="page-title-subheading">Nothing to display! Seems, there are no team associated with league.</div>
									</div>
								</div>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script>
	$('#start-selection').on('click', function(){
		$.ajax({
			url: base_path+"start-team-selection",
			type: "POST",
			data: {draft_url: '<?php echo $draft_details['draft_url']; ?>'},
			dataType: 'json',
			success: function (response) {
				if(response.status === 1){
					location.reload();
				}else{
					alert(response.message);
					location.reload();
				}
			}
		});
	});
	
</script>