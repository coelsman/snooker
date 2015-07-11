<div class="seasonTournament">
	<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Snooker', array('site/index')),
		    'links'=>array(
		    	'Season'=>array('site/season'),
		    	$season['SeasonName']=>array('site/season', 'sID'=>$season['SeasonID'], 't'=>'tournament'),
		    	$tournament->tournament_name
		    )
		));
	?>
	<div class="table-data">
		<div class="panel panel-primary">
			<div class="panel-heading">PLAYERS</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="width:22%;">Player</th>
							<th style="width:11%;"></th>
							<th style="width:22%;">Player</th>
							<th style="width:11%;"></th>
							<th style="width:22%;">Player</th>
							<th style="width:11%;"></th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($listPlayer)): $i = 1;?>

							<?php foreach ($listPlayer as $key => $value) { ?>
							<?php if ($i % 3 == 0) { ?>
									<td><?php echo $value['PlayerName']; ?></td>
									<td><?php if ($value['SeasonID'] != '' && $value['TournamentID'] != '') { ?>
										<input type="button" class="removePlayer btn btn-danger" id-player="<?php echo $value['PlayerID']; ?>" value="Remove">
									<?php } else { ?>
										<input type="button" class="addPlayer btn btn-info" id-player="<?php echo $value['PlayerID']; ?>" value="Add">
									<?php } ?></td>
								</tr>
							<?php } else if ($i % 3 == 1) { ?>
								<tr>
									<td><?php echo $value['PlayerName']; ?></td>
									<td><?php if ($value['SeasonID'] != '' && $value['TournamentID'] != '') { ?>
										<input type="button" class="removePlayer btn btn-danger" id-player="<?php echo $value['PlayerID']; ?>" value="Remove">
									<?php } else { ?>
										<input type="button" class="addPlayer btn btn-info" id-player="<?php echo $value['PlayerID']; ?>" value="Add">
									<?php } ?></td>
							<?php } else { ?>
									<td><?php echo $value['PlayerName']; ?></td>
									<td><?php if ($value['SeasonID'] != '' && $value['TournamentID'] != '') { ?>
										<input type="button" class="removePlayer btn btn-danger" id-player="<?php echo $value['PlayerID']; ?>" value="Remove">
									<?php } else { ?>
										<input type="button" class="addPlayer btn btn-info" id-player="<?php echo $value['PlayerID']; ?>" value="Add">
									<?php } ?></td>
							<?php } ?>
							<?php $i++; } ?>
						<?php endif; ?>
					</tbody>
				</table>
				<?php $this->widget('widget_pagination', array('totalRecord'=>147, 'recordPerPage'=>15, 'link'=>'site/season&sID='.$_GET['sID'].'&tID='.$_GET['tID'], 'valQuery'=>'pagePlayer')); ?>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">ROUNDS</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Round's Base Name</th>
							<th>Round's Name</th>
							<th>Race To</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($listRound)): $i = 1;?>

							<?php foreach ($listRound as $key => $value) { ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $value['RoundBaseName']; ?></td>
								<?php if ($value['SeasonID'] != '' && $value['TournamentID'] != '') { ?>
								<td><?php 
									if ($value['RoundName'] == '') { 
										echo $value['RoundBaseName'];
									} else { 
										echo $value['RoundName'];
									}
								?></td>
								<td><?php echo $value['RaceTo']; ?></td>
								<td>
									<a href="<?php echo Yii::app()->createUrl('site/season', array('sID'=>$_GET['sID'], 'tID'=>$_GET['tID'], 'rID'=>$value['RoundID'])); ?>" class="btn btn-warning">Detail</a>
									<input type="button" class="btn btn-primary" value="Edit">
									<input type="button" class="removeRound btn btn-danger" value="Remove" round-id="<?php echo $value['RoundID']; ?>">
								</td>
								<?php } else { ?>
								<td><input type="text" class="inputRoundName form-control" placeholder="Round's Name..."></td>
								<td><input type="text" class="inputRaceTo form-control"></td>
								<td><input type="button" class="addRound btn btn-info" value="Add" round-id="<?php echo $value['RoundID']; ?>"></td>
								<?php } ?>

							</tr>
							<?php $i++; } ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-warning">
			<div class="panel-heading">PRIZE FUNDS</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Position</th>
							<th>Prize Funds</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($listPrize)): $i = 1;?>
							<?php foreach ($listPrize as $key => $value) { ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $value['PositionName']; ?></td>
								<?php if ($value['SeasonID'] != '' && $value['TournamentID'] != '') { ?>
									<td><?php echo $value['PositionPrize']; ?></td>
									<td>
										<input type="button" class="editPrize btn btn-primary" data-id="<?php echo $value['PositionID']; ?>" value="Edit">
										<input type="button" class="removePrize btn btn-danger" data-id="<?php echo $value['PositionID']; ?>" value="Remove">
									</td>
								<?php } else { ?>
									<td><input type="text" class="inputPrize form-control" placeholder="Prize..."></td>
									<td><input type="button" class="addPrize btn btn-info" data-id="<?php echo $value['PositionID']; ?>" value="Add"></td>
								<?php } ?>
							</tr>
							<?php $i++; } ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="panel panel-danger">
			<div class="panel-heading">CENTURY BREAKS</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Player</th>
							<th>Break</th>
							<th>Opponent</th>
							<th>Round</th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($centuryBreak)): $i = 1; ?>
							<?php foreach ($centuryBreak as $key => $value) { ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $value['PlayerName']; ?></td>
									<td><?php echo $value['ResultScore']; ?></td>
									<td><?php  ?></td>
									<td><?php echo $value['RoundName']; ?></td>
								</tr>
							<?php $i++; } ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var season_id = <?php echo $_GET['sID']; ?>;
	var tournament_id = <?php echo $_GET['tID']; ?>;
	var interval;

	$(document).on('click', '.addPlayer', function () {
		var obj = $(this);
		var pID = $(this).attr('id-player');
		$.ajax({
			url: baseUrl + 'site/assignPlayerTournament',
			method: 'POST',
			data: {
				sID: season_id,
				tID: tournament_id,
				pID: pID
			},
			async: true,
			success: function (rs) {
				if (rs == 'OK') {
					obj.removeClass().addClass('btn btn-danger removePlayer').val('Remove')
					showSystemMessage(interval, 'Assign player successfully!', 'alert alert-success');
				}
			}
		});
	});

	$(document).on('click', '.removePlayer', function () {
		var obj = $(this);
		var pID = $(this).attr('id-player');
		$.ajax({
			url: baseUrl + 'site/removePlayerTournament',
			method: 'POST',
			data: {
				sID: season_id,
				tID: tournament_id,
				pID: pID
			},
			async: true,
			success: function (rs) {
				if (rs == 'OK') {
					obj.removeClass().addClass('btn btn-info addPlayer').val('Add');
					showSystemMessage(interval, 'Remove player successfully!', 'alert alert-success');
				}
			}
		});
	});

	$(document).on('click', '.addRound', function () {
		var obj = $(this);
		var rID = $(this).attr('round-id');
		var rName = $(this).parent().parent().find('.inputRoundName').val();
		var raceTo = $(this).parent().parent().find('.inputRaceTo').val();
		if (raceTo == '') {
			alert('Race To value is required.');
			return;
		}
		$.ajax({
			url: baseUrl + 'site/assignRoundTournament',
			method: 'POST',
			data: {
				sID: season_id,
				tID: tournament_id,
				rID: rID,
				rName: rName,
				raceTo: raceTo
			},
			async: false,
			success: function (rs) {
				if (rs == 'OK') {
					obj.parent().html('').html('<a class="btn btn-warning">Detail</a>' + 
						'<input type="button" class="btn btn-primary" value="Edit">' + 
						'<input type="button" class="removeRound btn btn-danger" value="Remove" round-id="'+rID+'">');
					showSystemMessage(interval, 'Assign round successfully!', 'alert alert-success');
				}
			}
		});
	});

	$(document).on('click', '.removeRound', function () {
		var obj = $(this);
		var rID = $(this).attr('round-id');
		$.ajax({
			url: baseUrl + 'site/removeRoundTournament',
			method: 'POST',
			data: {
				sID: season_id,
				tID: tournament_id,
				rID: rID
			},
			async: false,
			success: function (rs) {
				if (rs == 'OK') {
					obj.parent().html('').html('<input type="button" class="addRound btn btn-info" value="Add" round-id="'+rID+'">');
					showSystemMessage(interval, 'Assign round successfully!', 'alert alert-success');
				}
			}
		});
	});

	$(document).on('click', '.addPrize', function () {
		var obj = $(this);
		var regexPrize = /^[1-9][0-9]{2,5}$/;
		var prizeVal = obj.parent().parent().find('.inputPrize').val();
		var posID = obj.attr('data-id');
		if (!regexPrize.test(prizeVal)) {
			showSystemMessage(interval, 'Prize\'s value is incorrect.', 'alert alert-danger');
			return;
		}
		$.ajax({
			
		});
	});
</script>