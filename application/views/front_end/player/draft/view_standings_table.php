
<div class="row">
	<div class="col-sm-12">
		<div class="main-card mb-3">
			<div class="card-title">Standings Table</div>
			<div class="" style="width: auto; overflow-x: scroll;">
				<table class="mb-0 table table-border table-hover">
					<thead>
						<tr>
							<td class="text-success" style="width: 150px">Player Name</td>
							<?php if($associated_leagues){ foreach($associated_leagues as $league){ ?>
								<td style="font-size: 12px;font-weight: 500"><?php echo $league['league_title']; ?></td>
							<?php }} ?>
							<td class="text-warning text-center">Standing Score</td>
						</tr>
					</thead>
					<tbody>
						<?php if($no_draft == 2){ ?>
							<?php if($league_players){ foreach($league_players as $player){ ?>
								<tr
								   <?php
										if($player['user_id'] == $this->session->userdata('user_id')){
											$textColor = "text-light";
								?>
									style="background: #222550;"
								<?php
										}else{
											$textColor = "text-dark";
										}
								   ?>
								>
									<td class="<?php echo $textColor; ?>"><?php echo $player['full_name']; ?></td>
									
									<?php if($player['point_history']){ foreach($player['point_history'] as $key => $history){ ?>
										<td class="<?php echo $textColor; ?>">
											<div class="badge badge-warning"><?php echo $history; ?> </div>
											
											<?php
												if($player['team_name'][$key]){
											?>
												<div>
													<span class="text-success" style="font-size: 13px;"><?php echo $player['team_name'][$key]['team_title']; ?></span>
												</div>
											<?php 
												}
											?>
										</td>
									<?php }} ?>
									
									<td class="widget-heading text-success text-center"><?php echo $player['standing_score']; ?></td>
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
									<div class="alert alert-info fade show" role="alert">
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