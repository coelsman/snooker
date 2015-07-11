<div id="index">
	<div class="panel panel-success">
		<div class="panel-heading">Live Matches</div>
		<div class="panel-body">
			<table class="table">
				<tbody>
					<?php 
						$c = count($liveMatches);
						if ($c > 0) { 
							$nowTournament = '';
							for ($i=0; $i<$c; $i=$i+2) {
								if ($nowTournament != $liveMatches[$i]['TournamentName']) {
									$nowTournament = $liveMatches[$i]['TournamentName'];
					?>
					<thead>
						<tr>
							<th colspan="4"><?php echo $nowTournament; ?></th>
						</tr>
					</thead>
					<?php } ?>

					<?php
								if ($liveMatches[$i]['Score'] == '') $liveMatches[$i]['Score'] = 0;
								if ($liveMatches[$i+1]['Score'] == '') $liveMatches[$i+1]['Score'] = 0;
					?>
					<tr>
						<td style="width:35%;" class="text-right"><?php echo $liveMatches[$i]['PlayerName']; ?></td>
						<td style="width:20%;" class="text-center"><?php echo $liveMatches[$i]['Score'].' - '.$liveMatches[$i+1]['Score']; ?></td>
						<td style="width:35%;"><?php echo $liveMatches[$i+1]['PlayerName']; ?></td>
						<td style="width:10%;"><a class="btn btn-sm btn-danger">Live</a></td>
					</tr>
					<?php }} else { ?>
						<tr><td colspan="4"><center>No live matches now!</center></td></tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>