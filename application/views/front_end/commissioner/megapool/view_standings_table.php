
<div class="row">
	<div style="width: 100%">
		<div class="main-card mb-3">
			<div class="card-header">Standings Table</div>
			<div class="table-responsive"> 
				<table class="align-middle mb-0 table table-border table-striped table-hover">
					<thead>
						<tr>
							<th class="text-success">Player Name</th>
							<?php if($associated_leagues){ foreach($associated_leagues as $league){ ?>
								<th class="text-center"><?php echo $league['league_title']; ?></th>
							<?php }} ?>
						</tr>
					</thead>
					<tbody>
						<?php if($no_draft == 2){ ?>
							<?php if($league_players){ foreach($league_players as $player){ ?>
								<tr>
									<td class="text-muted"><?php echo $player['full_name']; ?></td>
									
									<?php if($player['point_history']){ foreach($player['point_history'] as $key => $history){ ?>
										<td class="text-center">
											<div class="badge badge-warning"><?php echo $history; ?> </div>
											
											<?php
												if($player['team_name'][$key]){
											?>
												<span class="text-success"><?php echo $player['team_name'][$key]; ?></span>
											<?php 
												}
											?>
										</td>
									<?php }} ?>
								</tr>
							<?php }}else{ ?>
								<tr>
									<td class="text-center" colspan=100>
										<div class="alert alert-danger fade show" role="alert">
											No player record found!
										</div>
									</td>
								</tr>
							<?php } ?>
						<?php }else{ ?>
							<tr>
								<td class="text-center" colspan=100>
									<div class="alert alert-danger fade show" role="alert">
										No draft created for this Megapool
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>