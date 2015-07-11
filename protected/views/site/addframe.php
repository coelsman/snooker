<div class="addframe">
	<pre><?php
		// $inforMatch = $matchData['infor'];
		// $detailMatch = $matchData['detail'];
		// $resultFrame = $matchData['result_frame'];
		// var_dump($matchPlayer); 
		/*$round_name = '';
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
		));*/
	?></pre>
	<?php if (Yii::app()->request->getQuery('type') == 'result') { ?>
		<input type="hidden" value="<?php echo $matchPlayer[0]['PlayerID']; ?>" id="hid-player-id-1">
		<input type="hidden" value="<?php echo $matchPlayer[1]['PlayerID']; ?>" id="hid-player-id-2">
		<table class="table table-bordered table-hovered tbl_addframe">
			<thead>
				<tr>
					<th><?php echo $matchPlayer[0]['PlayerName']; ?></th>
					<th><?php echo $matchPlayer[1]['PlayerName']; ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="radio" name="radio-frame-1" value="1" class="radio-check form-control">
						<input type="text" class="form-control txt-score txt-score-1" disabled="disabled" id="" value-player-id="<?php echo $matchPlayer[0]['PlayerID']; ?>">
					</td>
					<td>
						<input type="radio" name="radio-frame-1" value="2" class="radio-check form-control">
						<input type="text" class="form-control txt-score txt-score-2" disabled="disabled" id="" value-player-id="<?php echo $matchPlayer[1]['PlayerID']; ?>">
					</td>
					<td>
						<input type="button" class="btn btn-danger btn-remove" value="Remove">
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
						<input type="button" class="btn btn-warning btn-lg form-control" value="(+)" id="btn-add-result" style="margin-bottom:5px;">
						<input type="button" class="btn btn-success btn-lg form-control" value="Save" id="btn-save">
					</td>
				</tr>
			</tfoot>
		</table>
		<div class="hide" id="contain-new-tr">
			<div id="contain-tr-1">
				<input type="radio" name="radio-frame-2" value="1" class="radio-check form-control">
				<input type="text" class="form-control txt-score txt-score-1" disabled="disabled" id="" value-player-id="<?php echo $matchPlayer[0]['PlayerID']; ?>">
			</div>
			<div id="contain-tr-2">
				<input type="radio" name="radio-frame-2" value="2" class="radio-check form-control">
				<input type="text" class="form-control txt-score txt-score-2" disabled="disabled" id="" value-player-id="<?php echo $matchPlayer[1]['PlayerID']; ?>">
			</div>
			<div id="contain-tr-3">
				<input type="button" class="btn btn-danger btn-remove" value="Remove">
			</div>
		</div>
	<?php } else { ?>
		
	<?php } ?>
	
</div>
<script type="text/javascript">
	var nowNameNumber = 2;
	function addRowTable () {
		$('#contain-new-tr .radio-check').attr('name', 'radio-frame-'+nowNameNumber);
		var html;
		var html1 = $('#contain-new-tr #contain-tr-1').html();
		var html2 = $('#contain-new-tr #contain-tr-2').html();
		var html3 = $('#contain-new-tr #contain-tr-3').html();
		html = '<tr>' +
					'<td>'+html1+'</td>' +
					'<td>'+html2+'</td>' +
					'<td>'+html3+'</td>' +
				'</tr>';
		$('.tbl_addframe tbody').append(html);
		nowNameNumber++;
	}
	$('#btn-add-result').on('click', function () {
		addRowTable();
	});
	$('#btn-save').on('click', function () {
		var arrData = [], obj, point1, point2, objCheck, valPlayerID, valText;
		var pID1 = $('#hid-player-id-1').val();
		var pID2 = $('#hid-player-id-2').val();
		var regexPoint = /^[0-9]{1,3}$/;
		$('.tbl_addframe tbody tr').each(function () {
			obj = $(this);
			objCheck = obj.find('.radio-check:checked');
			checkValue = objCheck.val();
			if (checkValue === undefined) {
				arrData = [];
				return false;
			} else {
				valText = obj.find('.txt-score-'+checkValue).val();
				valPlayerID = obj.find('.txt-score-'+checkValue).attr('value-player-id');
				if (valText == '') {
					alert('You must type if you checked');
					obj.find('.txt-score-'+checkValue).focus();
					arrData = []
					return false;
				}
				if (!regexPoint.test(valText)) {
					alert('Point must be a number.');
					obj.find('.txt-score-'+checkValue).focus();
					arrData = []
					return false;
				}

				arrData.push({
					pID: valPlayerID,
					point: valText
				});
			}
		});
		if (arrData.length > 0) {
			$.ajax({
				url: baseUrl + 'site/addFrameResult',
				method: 'POST',
				data: {
					mID: <?php echo $_GET['mID'] ?>,
					dataPost: arrData,
					pID1: pID1,
					pID2: pID2
				},
				success: function (rt) {
					if (rt == 'OK') {
						alert('Insert success.');
						$('.tbl_addframe tbody').html('');
						addRowTable();
					}
				}
			});
		}
	});


	$(document).on('click', '.btn-remove', function () {
		$(this).parent().parent().remove();
	});

	$(document).on('click', '.radio-check', function () {
		$(this).parent().parent().find('.txt-score').attr('disabled', true);
		$(this).parent().find('.txt-score').attr('disabled', false);
	});
</script>