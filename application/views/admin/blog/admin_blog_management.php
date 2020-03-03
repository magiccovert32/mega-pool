
<div class="row">
	<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo  base_url('admin-add-blog'); ?>">
				<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow btn btn-success" data-original-title="Add Blog">
					<i class="fa fa-plus"></i>
				</button>
			</a>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Blog List
				</div>
			</div>
			<?php if($blog_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($blog_list as $list){ ?>
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left mr-4">
										<img width=50 src="<?php echo base_url('assets/uploads/blog_logo/'.$list['blog_image_path']) ?>">
									</div>
									<div class="widget-content-left">
										<div class="widget-heading">
											<strong class="text-success"><?php echo $list['blog_title']; ?></strong>
											<?php
												if($list['status'] == 1){
													$status_class="success";
													$status_text = "Active";
												}elseif($list['status'] == 2){
													$status_class="warning";
													$status_text = "In-active";
												}elseif($list['status'] == 3){
													$status_class="danger";
													$status_text = "Removed";
												}
											?>
											<div class="badge badge-<?php echo $status_class; ?> ml-2"><?php echo $status_text; ?></div>
										</div>
										<div class="widget-subheading"><i><?php echo substr($list['blog_content'],0,100).'...'; ?></i></div>
									</div>
									<div class="widget-content-right widget-content-actions">
										<a class="border-0 btn-transition btn btn-outline-success" href="<?php echo  base_url('admin-edit-blog/'.$list['blog_id']); ?>">
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
					<div class="alert alert-danger fade show" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">No blog found! Something went wrong.</div>
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