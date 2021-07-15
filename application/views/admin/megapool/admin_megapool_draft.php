
<div class="row">
	<div class="col-lg-12">
		<div class="card-header-tab card-header">
			<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
				<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Megapool List
			</div>
		</div>
		<?php if($draft_list){ ?>
			<div class="main-card mb-3 card">
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($draft_list as $list){ ?>
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<div class="widget-heading"> <?php echo $list['draft_title']; ?>
											<?php
												if($list['draft_status'] == 1){
													$status_class="success";
													$status_text = "Active";
												}elseif($list['draft_status'] == 2){
													$status_class="warning";
													$status_text = "In-active";
												}elseif($list['draft_status'] == 3){
													$status_class="danger";
													$status_text = "Removed";
												}else{
													$status_class="warning";
													$status_text = "Published";
												}
											?>
											<div class="badge badge-<?php echo $status_class; ?> ml-2"><?php echo $status_text; ?></div>
										</div>
										<div class="widget-subheading text-danger">
											<?php
												$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($list['team_selection_ends_on'])));
												$now 			= new DateTime();
												
												if($countDownDate > $now){
											?>
												<div class="widget-numbers text-success">Active</div>
											<?php }else{ ?>
												<div class="widget-numbers text-danger">Expired</div>
											<?php } ?>
											<div>
												<strong><?php echo @date('d-m-Y h:i A', strtotime($list['team_selection_ends_on'])); ?></strong>
											</div>
										</div>
									</div>
									<div class="widget-content-right widget-content-actions">
										<a class="border-0 btn-transition btn btn-outline-success" href="<?php echo  base_url('admin-edit-draft/'.$list['draft_id']); ?>">
											<i class="fa fa-edit"></i>
										</a>
									</div>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php }else{ ?>
			<br/>
			<div class="alert alert-danger fade show" role="alert">
				<div>
					<strong>Error</strong>
					<div class="page-title-subheading">No details found! Something went wrong.</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-sm-12">
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>