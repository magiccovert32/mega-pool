<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php $this->session->unset_userdata('league_item'); ?>
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
	
	
	<div class="col-lg-5">
		<form action="#" method="get">
			<div class="position-relative form-group">
				<label for="exampleEmail" class="card-title">Search by team name</label>
				<input name="team_name" id="team_name" placeholder="team name" type="text" class="form-control" autocomplete="off" value="<?php echo @$_GET['team_name']; ?>">
				<button type="button" class="mt-1 btn btn-primary" onclick="searchTeam();">Search</button>
			</div>
		</form>
	</div>
	
	<script>
		function searchTeam(){
			let team_name = $.trim($('#team_name').val());
			
			if(team_name.length > 0){
				window.location.replace("<?php echo base_url('admin-match-management?league_id='.$_GET['league_id']); ?>&team_name="+team_name);
			}else{
				window.location.replace("<?php echo base_url('admin-match-management?league_id='.$_GET['league_id']); ?>");
			}
		}
	</script>
	
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
									
									<?php if($list['match_time'] != null){ ?>
										<div class="text-dark mr-3">
											<small>From <?php echo @date('h:i A', strtotime($list['match_time'])); ?></small>
										</div>
									<?php } ?>
								</div>
								<div class="col-sm-12 col-md-3  col-xs-12 mb-2">
									<div class="widget-content-wrapper" style="justify-content: flex-start;">
										<div class="widget-content-left mr-3">
											<img width="50" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$list['home_team_logo']); ?>" alt="">
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
											<img width="50" class="img-fluid img-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$list['away_team_logo']); ?>" alt="">
										</div>
									</div>
								</div>
								
								<a href="<?php echo base_url('admin-edit-match/'.$list['match_url']); ?>">
									<div class="badge badge-info ml-2">Edit</div>
								</a>
								
								<?php if($list['is_published'] == 2){ ?>
									<a href="javascript:void(0)" class="publish-match" data-match-id = "<?php echo $list['match_url']; ?>">
										<div class="badge badge-warning ml-2">Publish</div>
									</a>
								<?php }else{ ?>
									<a href="#">
										<div class="badge badge-warning ml-2">Published</div>
									</a>
								<?php } ?>
							</div>
						</li>
					<?php } ?>
				</ul>
			<?php }else{ ?>
				<div class="card-body">
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