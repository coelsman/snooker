<?php
	
?>
<div class="matchall">
	<div class="table-data">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Player 1</th>
					<th>Score</th>
					<th>Player 2</th>
					<th>Tournament</th>
					<th>Round</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if ($listMatch != NULL): 
						$no = 1;
						for ($i=0, $c=count($listMatch); $i<$c; $i=$i+2) {
				?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $listMatch[$i]['PlayerName']; ?></td>
						<td><?php echo $listMatch[$i]['Score'].' - '.$listMatch[$i+1]['Score']; ?></td>
						<td><?php echo $listMatch[$i+1]['PlayerName'] ?></td>
						<td><?php echo $listMatch[$i]['TournamentName']; ?></td>
						<td><?php  ?></td>
						<td><?php  ?></td>
					</tr>
				<?php $no++; } endif; ?>
			</tbody>
		</table>
	</div>
</div>