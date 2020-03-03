
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo  base_url('my-wallet'); ?>">
				<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow btn btn-success" data-original-title="Back">
					<i class="pe-7s-angle-left-circle"></i>
				</button>
			</a>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Mega Pool Leagues
				</div>
			</div>
			<?php if($transaction_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($transaction_list as $list){ ?>
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left mr-4">
										<div class="widget-numbers text-success">$<?php echo $list['transaction_amount']; ?></div>
									</div>
									<div class="widget-content-left">
										<div class="widget-heading"> 
											<?php
												if($list['transaction_type'] == 1){
													$status_class="success";
													$status_text = "Received";
												}elseif($list['transaction_type'] == 2){
													$status_class="warning";
													$status_text = "Invested";
												}else{
													$status_class="muted";
													$status_text = "Not specified";
												}
											?>
											<div class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></div>
										</div>

										<div><small>Date <?php echo @date('Y-m-d', strtotime($list['transaction_date'])); ?></small></div>
										<div class="row">
											<div class="col-sm-12 text-info"><?php echo $list['transaction_purpose']; ?></p>	
										</div>
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
							<div class="page-title-subheading">Nothing to display! Seems, there is no transaction yet.</div>
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