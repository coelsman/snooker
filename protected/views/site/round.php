<div class="roundTournament">
	<?php
		$round_name = '';
		if ($round['SeasonID'] != '' && $round['TournamentID'] != '') {
			if ($round['RoundName'] != NULL && $round['RoundName'] != '') {
				$round_name = $round['RoundName'];
			} else {
				$round_name = $round['RoundBaseName'];
			}
		}
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Snooker', array('site/index')),
		    'links'=>array(
		    	'Season'=>array('site/season'),
		    	$season['SeasonName']=>array('site/season', 'sID'=>$season['SeasonID'], 't'=>'tournament'),
		    	$tournament->tournament_name=>array('site/season', 'sID'=>$season['SeasonID'], 'tID'=>$tournament->tournament_id),
		    	$round_name
		    )
		));
		$checkPlayer = array();
	?>
	<div class="table-data">
		<div class="panel panel-primary">
			<div class="panel-heading">MATCHES</div>
			<div class="panel-body">
				<input type="button" id="btn-add-match" class="btn btn-success" value="Add Match" style="margin-bottom:10px;">
				<input type="hidden" id="hid-sID" value="<?php echo $_GET['sID']; ?>">
				<input type="hidden" id="hid-tID" value="<?php echo $_GET['tID']; ?>">
				<input type="hidden" id="hid-rID" value="<?php echo $_GET['rID']; ?>">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="width:5%;">No.</th>
							<th style="width:25%; text-align:right;">Player 1</th>
							<th style="width:15%; text-align:center;" colspan="3">Score</th>
							<th style="width:25%;">Player 2</th>
							<th style="width:30%;"></th>
						</tr>
					</thead>
					<tbody><?php if (isset($listMatch)) { $j = 1; ?>
						<?php 
							for ($i=0, $c=count($listMatch); $i<$c; $i = $i+2) { 
								$checkPlayer[$listMatch[$i]['PlayerName']] = 'label-success';
								$checkPlayer[$listMatch[$i+1]['PlayerName']] = 'label-success';
						?>
							<tr>
								<td><?php echo $j; ?></td>
								<td style="text-align:right;"><?php echo $listMatch[$i]['PlayerName']; ?></td>
								<td style="text-align:right;">
									<div class="div-score-1"><?php echo $listMatch[$i]['MatchScore']; ?></div>
									<input type="text" class="hide txt-update-match-1" value="<?php echo $listMatch[$i]['MatchScore']; ?>" id="">
								</td>
								<td style="text-align:center;"> - </td>
								<td>
									<div class="div-score-2"><?php echo $listMatch[$i+1]['MatchScore']; ?></div>
									<input type="text" class="hide txt-update-match-2" value="<?php echo $listMatch[$i+1]['MatchScore']; ?>" id="">
								</td>
								<td><?php echo $listMatch[$i+1]['PlayerName']; ?></td>
								<td>
									<input type="hidden" value="<?php echo $listMatch[$i]['PlayerID']; ?>" class="player-id-1">
									<input type="hidden" value="<?php echo $listMatch[$i+1]['PlayerID']; ?>" class="player-id-2">
									<a href="<?php echo Yii::app()->createUrl('site/match', array('mID'=>$listMatch[$i]['MatchID'])); ?>" class="btn btn-warning">Details</a>
									<input type="button" class="btn btn-info btn-update-match" value="Update">
									<input type="button" class="hide btn-save-match" value="Save" value-match-id="<?php echo $listMatch[$i]['MatchID']; ?>">
								</td>
							</tr>
						<?php $j++; } ?>
					<?php } ?></tbody>
				</table>
				<?php $this->widget('widget_pagination', array('totalRecord'=>67, 'recordPerPage'=>15, 'link'=>'site/season&sID='.$_GET['sID'].'&tID='.$_GET['tID'].'&rID='.$_GET['rID'])); ?>
			</div>
		</div>

		<div class="panel panel-warning">
			<div class="panel-heading">MATCHES</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="width:25%;">Player</th>
							<th style="width:8%;">Status</th>
							<th style="width:25%;">Player</th>
							<th style="width:8%;">Status</th>
							<th style="width:25%;">Player</th>
							<th style="width:8%;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php

							for ($i=0, $c=count($activeUser); $i<$c; $i=$i+3) {

						?>
						<tr>
							<td><?php echo $activeUser[$i]['PlayerName']; ?></td>
							<td><?php if (isset($checkPlayer[$activeUser[$i]['PlayerName']])) { ?>
								<label class="label label-success">Marked</label>
							<?php } else { ?>
								<label class="label label-primary">Free</label>
							<?php } ?></td>

							<td><?php if (isset($activeUser[$i+1])) {
								$name = $activeUser[$i+1]['PlayerName'];
								echo $activeUser[$i+1]['PlayerName']; ?>
							</td><?php } else { $name = ''; } ?>
							<td><?php if (isset($checkPlayer[$name])) { ?>
								<label class="label label-success">Marked</label>
							<?php } else { ?>
								<label class="label label-primary">Free</label>
							<?php } ?></td>

							<td><?php if (isset($activeUser[$i+2])) {
								$name = $activeUser[$i+2]['PlayerName'];
								echo $activeUser[$i+2]['PlayerName']; ?>
							</td><?php } else { $name = ''; } ?>
							<td><?php if (isset($checkPlayer[$name])) { ?>
								<label class="label label-success">Marked</label>
							<?php } else { ?>
								<label class="label label-primary">Free</label>
							<?php } ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php // $this->widget('widget_pagination', array('totalRecord'=>67, 'recordPerPage'=>15, 'link'=>'site/season&sID='.$_GET['sID'].'&tID='.$_GET['tID'].'&rID='.$_GET['rID'])); ?>
			</div>
		</div>
	</div>

	<!-- modal add match -->
	<div class="modal fade" id="popup-add-match">
		<div class="modal-dialog">
			<div class="modal-content" style="width:400px; margin:auto;">
				<div class="modal-body">
					<div id="alert"></div>
					<?php
						$html = '';
						if (count($activeUser) > 0) {
							foreach ($activeUser as $key => $value) {
								$html .= '<option value="'.$value['PlayerID'].'">'.$value['PlayerName'].'</option>';
							}
						}
					?>
					<div style="margin-bottom:6px;">
						<span class="title">Choose Player 1: </span>
						<select class="form-control" id="slc-add-match-1">
							<option value="-1"></option>
							<?php echo $html; ?>
						</select>
					</div>
					<div>
						<span class="title">Choose Player 2: </span>
						<select class="form-control" id="slc-add-match-2">
							<option value="-1"></option>
							<?php echo $html; ?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" id="btn-cancel" class="btn btn-default" value="Cancel">
					<input type="button" id="btn-add-ok" class="btn btn-primary" value="OK">
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
<script type="text/javascript">
	$('#btn-add-match').on('click', function () {
		$('#popup-add-match').modal('show');
	});

	$('#popup-add-match #btn-cancel').click(function () {
		$('#popup-add-match').modal('hide');
	});

	$('#popup-add-match #btn-add-ok').click(function () {
		var p1 = $('#slc-add-match-1 option:selected').val();
		var p2 = $('#slc-add-match-2 option:selected').val();

		if (p1 == '-1' || p2 == '-1') {
			$('#popup-add-match #alert').removeClass().addClass('alert alert-danger').html('Both players should be chosen.');
			return;
		}
		if (p1 == p2) {
			$('#popup-add-match #alert').removeClass().addClass('alert alert-danger').html('A match requires 2 players.');
			return;
		}

		var sID = $('#hid-sID').val();
		var tID = $('#hid-tID').val();
		var rID = $('#hid-rID').val();

		$.ajax({
			url: baseUrl + 'site/createMatch',
			method: 'POST',
			data: {
				sID: sID,
				tID: tID,
				rID: rID,
				pl1: p1,
				pl2: p2
			},
			success: function (json) {
				if (json == 'OK') {
					$('#popup-add-match #alert').removeClass().addClass('alert alert-success').html('Add match successfully.');
				} else {
					$('#popup-add-match #alert').removeClass().addClass('alert alert-danger').html('Add match fail.');
				}
			}
		});
	});

	$('.btn-update-match').unbind().click(function () {
		var obj = $(this);
		var oldVal1 = obj.parent().parent().find('.txt-update-match-1').val();
		var oldVal2 = obj.parent().parent().find('.txt-update-match-2').val();

		obj.parent().parent().find('.txt-update-match-1').removeClass().addClass('txt-update-match-1 form-control');
		obj.parent().parent().find('.div-score-1').removeClass().addClass('div-score-1 hide');
		obj.parent().parent().find('.txt-update-match-2').removeClass().addClass('txt-update-match-2 form-control');
		obj.parent().parent().find('.div-score-2').removeClass().addClass('div-score-2 hide');

		$(this).removeClass().addClass('btn-update-match hide');
		obj.parent().find('.btn-save-match').removeClass().addClass('btn-save-match btn btn-success');

		$('.btn-save-match').on('click', function () {
			var obj2 = $(this);
			var newVal1 = obj2.parent().parent().find('.txt-update-match-1').val();
			var newVal2 = obj2.parent().parent().find('.txt-update-match-2').val();

			if (newVal1 == oldVal1 && newVal2 == oldVal2) {
				obj2.parent().parent().find('.txt-update-match-1').removeClass().addClass('txt-update-match-1 hide');
				obj2.parent().parent().find('.div-score-1').removeClass().addClass('div-score-1');
				obj2.parent().parent().find('.txt-update-match-2').removeClass().addClass('txt-update-match-2 hide');
				obj2.parent().parent().find('.div-score-2').removeClass().addClass('div-score-2');

				$(this).removeClass().addClass('btn-save-match hide');
				obj.parent().find('.btn-update-match').removeClass().addClass('btn-update-match btn btn-info');
				return;
			}
			var mID = obj2.attr('value-match-id');
			var pID1 = obj2.parent().find('.player-id-1').val();
			var pID2 = obj2.parent().find('.player-id-2').val();
			$.ajax({
				url: baseUrl + 'site/updateScoreMatch',
				method: 'POST', 
				data: {
					mID: mID,
					score1: newVal1,
					score2: newVal2,
					pID1: pID1,
					pID2: pID2
				},
				success: function (json) {
					obj2.parent().parent().find('.txt-update-match-1').removeClass().addClass('txt-update-match-1 hide').val(newVal1);
					obj2.parent().parent().find('.div-score-1').removeClass().addClass('div-score-1').html(newVal1);
					obj2.parent().parent().find('.txt-update-match-2').removeClass().addClass('txt-update-match-2 hide').val(newVal2);
					obj2.parent().parent().find('.div-score-2').removeClass().addClass('div-score-2').html(newVal2);

					$(this).removeClass().addClass('btn-save-match hide');
					obj.parent().find('.btn-update-match').removeClass().addClass('btn-update-match btn btn-info');
				}
			});
		});
	});
</script>