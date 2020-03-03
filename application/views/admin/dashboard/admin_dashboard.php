<div class="card no-shadow bg-transparent no-border rm-borders mb-3">
	<div class="card">
		<div class="no-gutters row">
			<div class="col-md-12 col-lg-6 col-xl-3">
				<div class="pt-0 pb-0 card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Total Leagues</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-primary"><?php echo $league_count; ?></div>
										</div>
									</div>
									<div class="widget-progress-wrapper">
										<div class="progress-bar-sm progress-bar-animated-alt progress">
											<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%;"></div>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<div class="pt-0 pb-0 card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Total Teams</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-success"><?php echo $team_count; ?></div>
										</div>
									</div>
									<div class="widget-progress-wrapper">
										<div class="progress-bar-sm progress-bar-animated-alt progress">
											<div class="progress-bar bg-success" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%;"></div>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<div class="pt-0 pb-0 card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Commissioners</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-danger">
												<?php echo $commissioner_count; ?>
											</div>
										</div>
									</div>
									<div class="widget-progress-wrapper">
										<div class="progress-bar-sm progress-bar-animated-alt progress">
											<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%;"></div>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-12 col-lg-6 col-xl-3">
				<div class="pt-0 pb-0 card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-outer">
									<div class="widget-content-wrapper">
										<div class="widget-content-left">
											<div class="widget-heading">Players</div>
										</div>
										<div class="widget-content-right">
											<div class="widget-numbers text-focus"><?php echo $player_count; ?></div>
										</div>
									</div>
									<div class="widget-progress-wrapper">
										<div class="progress-bar-sm progress-bar-animated-alt progress">
											<div class="progress-bar bg-focus" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%;"></div>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<br/>
	<a href="<?php echo base_url('update-match-point'); ?>"><button class="mt-1 btn btn-primary" type="button">Update Player Point</button></a>
</div>