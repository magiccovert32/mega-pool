<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details && $draft_details){ ?>
				
					<div class="no-gutters row">
						<div class="col-md-4 col-xl-4">
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
										<div>
											<span>Created on <?php echo @date('Y-m-d h:i:s', strtotime($draft_details['created_on'])); ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-4 col-xl-4">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<div class="widget-heading text-info">Selected League</div>
										<div class="widget-subheading"><?php echo $draft_details['league_title']; ?></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-4 col-xl-4">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<div class="widget-heading text-warning">Associated Megapool</div>
										<div class="widget-subheading"><?php echo $draft_details['mega_pool_title']; ?></div>
									</div>
								</div>
							</div>
						</div>
		
						<div class="col-md-12 col-xl-12 card-footer">
							<div class="widget-content-right ml-3 mt-3">
								<a class="widget-content-left ml-0" href="<?php echo base_url('my-draft') ?>">
									<div class=" btn-pill btn btn-outline-dark">Back to Draft</div>
								</a>
							</div>
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