<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details){ ?>
					<h5 class="card-title">Standing Table</h5>
					
					<?php
						if($league_team_position){
						if($league_team_count > 0){
					?>
						<table class="mb-0 table table-striped">
							<thead>
								<tr>
									<th>Rank</th>
									<th>Team</th>
									<th class="text-center">Points</th>
									<th class="text-center">Played</th>
									<th class="text-center">Won</th>
									<th class="text-center">Drawn</th>
									<th class="text-center">Lost</th>
									<th class="text-center">Score</th>
								</tr>
							</thead>
							<tbody>
								<?php if($team_score_position){ foreach($team_score_position as $key => $team){ $k = $key+1; ?>
								
									<?php
										if($k < 6){
											$rank_color = '#0ac93d';
										}elseif($k > 5 && $k < 11){
											$rank_color = '#e3c010';
										}elseif($k > 10 && $k < 16){
											$rank_color = '#e36810';
										}elseif($k > 15 && $k < 21){
											$rank_color = '#e67a3c';
										}else{
											$rank_color = '#e31010';
										}
									?>
									<tr>
										<th scope="row" style="color: <?php echo $rank_color; ?>">#<?php echo $k; ?></th>
										<td><img class="img-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$team['team_logo']) ?>" style="width: 30px;height: 30px;margin-right: 10px;"> <?php echo $team['team_title']; ?></td>
										<td class="text-center"><span class="text-success" style="font-weight: 700;"><?php echo $team['total_point']; ?></span></td>
										<td class="text-center"><?php echo $team['play_count']; ?></td>
										<td class="text-center"><?php echo $team['win_count']; ?></td>
										<td class="text-center"><?php echo $team['draw_count']; ?></td>
										<td class="text-center"><?php echo $team['play_count'] - $team['win_count'] - $team['draw_count'] ; ?></td>
										<td class="text-center">
											<span class="text-danger" style="font-weight: 700;">
											<?php
												if($team['play_count'] == 0){
													echo 0;
												}else{
													echo $league_team_position[$key]['score'];
												}
											?>
											</span>
										</td>
									</tr>
								<?php }} ?>
							</tbody>
						</table>
					<?php }else{ ?>
						<div class="alert alert-info fade show mt-10" role="alert">
							<div>
								<strong>Error</strong>
								<div class="page-title-subheading">No team found!</div>
							</div>
						</div>
					<?php }}else{ ?>
						<div class="alert alert-info fade show mt-10" role="alert">
							<div>
								<strong>Error</strong>
								<div class="page-title-subheading">No position score added</div>
							</div>
						</div>
					<?php } ?>
				<?php }else{ ?>
					<div class="alert alert-danger fade show mt-10" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">Invalid league!</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>