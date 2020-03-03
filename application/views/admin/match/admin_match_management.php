<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-lg-4 mb-2">
		<div class="position-relative form-group">
			<form id="search-frm" action="<?php echo base_url('admin-match-management'); ?>" method="get">
				<label for="league_id" class="">Select League</label>
				<select name="league_id" id="league_id" class="form-control">
					<option value="">Choose...</option>
					<?php if($league_list){ ?>
						<?php foreach($league_list as $list){ ?>
							<option <?php if(!empty($_GET['league_id'])){ if($_GET['league_id'] == $list['league_id']){ echo "selected"; }} ?> value="<?php echo $list['league_id']; ?>"><?php echo $list['league_title']; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</form>
		</div>
	</div>
	
	<div class="col-lg-12 mb-2">
		<div class="bg-white mr-3" style="width: 40px;height: 20px;float: left;border: 1px solid #222;">
			
		</div>
		<div style="width: 100px;height: 20px;float: left;">
			<b>Upcoming</b>
		</div>
		<div class="bg-light mr-3"  style="width: 40px;height: 20px;float: left;border: 1px solid #222;">
			
		</div>
		<div style="width: 140px;height: 20px;float: left;">
			<b>Already played</b>
		</div>
	</div>
	
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Match List
				</div>
			</div>
			<?php if($match_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($match_list as $list){ ?>
						
						<?php
							$date 	= new DateTime($list['match_date']);
							$now 	= new DateTime();
							
							if($date < $now) {
								$bg = 'bg-light';
								$text_bg = "badge-warning";
								$text = 'played';
							}else{
								$bg = 'bg-white';
								$text_bg = "badge-success";
								$text = 'upcoming';
							}
						?>
						
						<li class="list-group-item <?php echo $bg; ?>">
							<div class="row widget-content p-0">
								<div class="col-sm-12 col-md-2  col-xs-12 mb-2">
									<div class="widget-content-wrapper" style="justify-content: flex-start;">
										<div class="text-success mr-3">
											<strong><?php echo @date('Y-m-d', strtotime($list['match_date'])); ?></strong>
										</div>
										
									</div>
									<div class="<?php echo $text_bg; ?> badge badge-pill text-white text-center"><?php echo $text; ?></div>
								</div>
								<div class="col-sm-12 col-md-3  col-xs-12 mb-2">
									<div class="widget-content-wrapper" style="justify-content: flex-start;">
										<div class="widget-content-left mr-3">
											<img width="30" class="image-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$list['home_team_logo']); ?>" alt="">
										</div>
										<div class="widget-content-left">
											<div class="text-dark"><?php echo $list['home_team']; ?></div>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-2 col-xs-12 mb-2">
									<div class="widget-content-wrapper" style="justify-content: center;">
										<div class="widget-numbers text-success">
											<?php echo $list['home_team_score']; ?> : <?php echo $list['away_team_score']; ?>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-3">
									<div class="widget-content-wrapper" style="justify-content: flex-end;">
										<div class="widget-content-left mr-3">
											<div class="text-dark"><?php echo $list['away_team']; ?></div>
										</div>
										<div class="widget-content-left">
											<img width="30" class="image-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$list['away_team_logo']); ?>" alt="">
										</div>
									</div>
								</div>
								
								<?php if($list['is_published'] == 2){ ?>
									<div class="col-sm-12 col-md-1">
										<div class="widget-content-wrapper" style="justify-content: center;">
											<a href="<?php echo base_url('admin-edit-match/'.$list['match_url']); ?>">
												<div class="text-info"><strong>Manage</strong></div>
											</a>
										</div>
									</div>
								<?php } ?>
								
								<?php if($list['is_published'] == 2){ ?>
									<div class="col-sm-12 col-md-1">
										<div class="widget-content-wrapper" style="justify-content: center;">
											<a href="#" class="publish-match" data-match-id = "<?php echo $list['match_url']; ?>">
												<button class="mt-1 btn btn-warning" type="button">Publish</button>
											</a>
										</div>
									</div>
								<?php }else{ ?>
									<div class="col-sm-12 col-md-2">
										<div class="widget-content-wrapper" style="justify-content: center;">
											<strong class="text-success">Published</strong>
										</div>
									</div>
								<?php } ?>
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
							<div class="page-title-subheading">Nothing to display! Seems, there are no match created yet.</div>
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

<script>
	$('#league_id').on('change', function(){
		$('#search-frm').submit();
	});
	
	$('.publish-match').on('click', function(){		
		var url = $(this).attr('data-match-id');
		
		swal({
			title: "Are you sure?",
			text: "Once published, you will not be able to modify the match. Please make sure all the informations are ready to be online.",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: base_path+"publish-match/"+url,
					type: "POST",
					dataType: 'json',
					success: function (response) {
						if(response.status == 1){
							setTimeout(function(){
								location.reload();
							},500);
						}else{
							swal({
								title: "Error",
								text: response.message,
								icon: "error",
								button: "Close",
							});
						}
					}
				});
			} 
		});
	});
</script>