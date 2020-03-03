
<div class="row">
	<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo  base_url('admin-add-league'); ?>">
				<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow btn btn-success" data-original-title="Add League">
					<i class="fa fa-plus"></i>
				</button>
			</a>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Leagues List
				</div>
			</div>
			<?php if($league_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($league_list as $list){ ?>
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left mr-4">
										<img width=50 height=50 src="<?php echo base_url('assets/uploads/league_logo/'.$list['league_logo']) ?>" class="img-thumbnail">
									</div>
									<div class="widget-content-left">
										<div class="widget-heading"> <?php echo $list['league_title']; ?>
											<?php
												if($list['league_status'] == 1){
													$status_class="success";
													$status_text = "Active";
												}elseif($list['league_status'] == 2){
													$status_class="warning";
													$status_text = "In-active";
												}elseif($list['league_status'] == 3){
													$status_class="danger";
													$status_text = "Removed";
												}
											?>
											<div class="badge badge-<?php echo $status_class; ?> ml-2"><?php echo $status_text; ?></div>
										</div>
										<div class="widget-subheading"><i><?php echo substr($list['league_description'],0,100).'...'; ?></i></div>
									</div>
									<div class="widget-content-right widget-content-actions">
										<a href="<?php echo  base_url('admin-edit-league/'.$list['league_id']); ?>">
											<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success"><i class="pe-7s-tools btn-icon-wrapper"> </i>Edit</button>
										</a>
										<a href="<?php echo  base_url('admin-attatch-team-with-league/'.$list['league_id']); ?>">
											<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-primary"><i class="pe-7s-plus btn-icon-wrapper"> </i>Add Team</button>
										</a>
										<a href="<?php echo  base_url('admin-league-table/'.$list['league_id']); ?>">
											<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-warning"><i class="pe-7s-menu btn-icon-wrapper"> </i>Table</button>
										</a>
										<a href="<?php echo  base_url('admin-league-standing-table/'.$list['league_id']); ?>">
											<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-warning"><i class="pe-7s-menu btn-icon-wrapper"> </i>Standing Table</button>
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
					<div class="alert alert-danger fade show" role="alert">
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