<div class="row">
	<div class="col-md-6 col-xl-4">
		<div class="card mb-3 widget-content">
			<div class="widget-content-outer">
				<div class="widget-content-wrapper">
					<div class="widget-content-left">
						<div class="widget-heading">Total Megapool</div>
						<div class="widget-subheading">Your created Megapool</div>
					</div>
					<div class="widget-content-right">
						<div class="widget-numbers text-success"><?php echo $megapool_count; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card mb-3 widget-content">
			<div class="widget-content-outer">
				<div class="widget-content-wrapper">
					<div class="widget-content-left">
						<div class="widget-heading">Total Draft</div>
						<div class="widget-subheading">Your created Drafts</div>
					</div>
					<div class="widget-content-right">
						<div class="widget-numbers text-warning"><?php echo $draft_count; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card mb-3 widget-content">
			<div class="widget-content-outer">
				<div class="widget-content-wrapper">
					<div class="widget-content-left">
						<div class="widget-heading">Total Players</div>
						<div class="widget-subheading">Megapool players</div>
					</div>
					<div class="widget-content-right">
						<div class="widget-numbers text-danger"><?php echo $player_count; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="widget-heading text-dark">Select your Megapool to see the Standing Table</h5>
				<div class="row">
					<div class="col-sm-12 col-md-4">
						<div class="position-relative form-group">
							<label for="megapool-id" class="">Megapool List :</label>
							<select name="select" id="megapool-id" class="form-control">
								<option value="">Choose...</option>
								<?php if($megapool_list){ foreach($megapool_list as $megapool){ ?>
									<option value="<?php echo $megapool['mega_pool_url']; ?>"><?php echo $megapool['mega_pool_title']; ?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
				</div>
				
				<div id="standing-table">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="alert alert-info fade show" role="alert">
								<span class="alert-link">Megapool Standing Table</span> will be displayed here!
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/commissioner/view_standing_table.js'); ?>" ></script>