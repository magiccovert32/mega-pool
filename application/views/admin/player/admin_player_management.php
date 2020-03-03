
<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Players List
				</div>
			</div>
			<?php if($player_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($player_list as $list){ ?>
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left mr-4">
										<?php if($list['profile_image'] != ''){ ?>
											<img width=50 height=50 src="<?php echo base_url('assets/uploads/profile_image/'.$list['profile_image']) ?>" class="img-thumbnail">
										<?php }else{ ?>
											<img width=50 height=50 src="<?php echo base_url('assets/images/user.png'); ?>" class="img-thumbnail">
										<?php } ?>
									</div>
									<div class="widget-content-left">
										<div class="widget-heading">
											<?php echo $list['full_name']; ?>
										</div>
										<div class="widget-subheading"><i><?php echo $list['user_email']; ?></i></div>
										<?php
											if($list['current_status'] == 1){
												$status_class="success";
												$status_text = "Active";
											}elseif($list['current_status'] == 2){
												$status_class="warning";
												$status_text = "In-active";
											}elseif($list['current_status'] == 3){
												$status_class="danger";
												$status_text = "Blocked";
											}elseif($list['current_status'] == 4){
												$status_class="warning";
												$status_text = "Email un-verified";
											}
										?>
										<div class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></div>
										
										<?php
											if($list['is_email_verified'] == 1){
												$status_class="success";
												$status_text = "Email Verified";
											}elseif($list['current_status'] == 2){
												$status_class="warning";
												$status_text = "Email unverified";
											}
										?>
										<div class="badge badge-<?php echo $status_class; ?> ml-2"><?php echo $status_text; ?></div>
										<div class="badge badge-primary">Joined on <?php echo @date('Y-m-d', strtotime($list['registration_date'])); ?></div>
									</div>
									<div class="widget-content-right widget-content-actions">
										<a class="border-0 btn-transition btn btn-outline-success" href="<?php echo  base_url('admin-edit-player/'.$list['user_id']); ?>">
											<i class="fa fa-edit"></i>
										</a>
									</div>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			<?php }else{ ?>
				<div class="col-md-12">
					<br/>
					<div class="alert alert-info fade show" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">Nothing to display! Seems, there are no player registered yet.</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>