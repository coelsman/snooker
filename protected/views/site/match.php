<div class="match">
	<pre><?php
		$inforMatch = $matchData['infor'];
		$detailMatch = $matchData['detail'];
		$resultFrame = $matchData['result_frame'];
		// var_dump($resultFrame); 
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
	<div class="table-data">
		<div class="panel panel-primary">
			<div class="panel-heading">MATCHES</div>
			<div class="panel-body">
				<div class="match-result">
					<div class="item">
						<div class="player"><?php echo strtoupper($inforMatch[0]['PlayerName']); ?></div>
						<div class="score"><?php echo strtoupper($inforMatch[0]['MatchScore']); ?></div>
						<div class="clearfix"></div>
					</div>
					<div class="item">
						<div class="player"><?php echo strtoupper($inforMatch[1]['PlayerName']); ?></div>
						<div class="score"><?php echo strtoupper($inforMatch[1]['MatchScore']); ?></div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php
					if ($detailMatch != []) {
						$frameNow = 1;
						foreach ($detailMatch as $key => $value) {
				?>
					<table class="table">
						<thead>
							<tr>
								<td style="border:1px solid #B1B1F4; font-size:14px;" colspan="3">FRAME <?php echo $frameNow; ?></td>
							</tr>
						</thead>
						<tbody>	
							<?php
								$frPlayer = array(
									$inforMatch[0]['PlayerName']=>'',
									$inforMatch[1]['PlayerName']=>''
								);
								foreach ($value as $key2 => $value2) {
									if ($value2['name'] == $inforMatch[0]['PlayerName']) {
										if ($value2['FrameScore'] >= 100) {
											$frPlayer[$inforMatch[0]['PlayerName']] .= '<span class="text-red">'.$value2['FrameScore'].'</span>';
										} else {
											$frPlayer[$inforMatch[0]['PlayerName']] .= '<span>'.$value2['FrameScore'].'</span>';
										}
										$frPlayer[$inforMatch[1]['PlayerName']] .= '<span>...</span>';
									} else {
										if ($value2['FrameScore'] >= 100) {
											$frPlayer[$inforMatch[1]['PlayerName']] .= '<span class="text-red">'.$value2['FrameScore'].'</span>';
										} else {
											$frPlayer[$inforMatch[1]['PlayerName']] .= '<span>'.$value2['FrameScore'].'</span>';
										}
										$frPlayer[$inforMatch[0]['PlayerName']] .= '<span>...</span>';
									}
								}
							?>
							<tr class="row-item">
								<?php if (count($resultFrame[$value2['FrameID']]) > 0) { ?>
									<?php if ($resultFrame[$value2['FrameID']][0]['FrameScore'] > $resultFrame[$value2['FrameID']][1]['FrameScore']) { ?>
										<td class="item-player-name text-red"><?php echo $inforMatch[0]['PlayerName']; ?></td>
									<?php } else { ?>
										<td class="item-player-name"><?php echo $inforMatch[0]['PlayerName']; ?></td>
									<?php } ?>
								<?php } else { ?>
									<td class="item-player-name"><?php echo $inforMatch[0]['PlayerName']; ?></td>
								<?php } ?>
								<td class="item-result-frame" contenteditable value-player-id="<?php echo $inforMatch[0]['PlayerID']; ?>" value-frame-id="<?php echo $value2['FrameID']; ?>"><?php 
									if (count($resultFrame[$value2['FrameID']]) > 0) {
										echo $resultFrame[$value2['FrameID']][0]['FrameScore']; 
									}
								?></td>
								<td class="item-score"><?php echo $frPlayer[$inforMatch[0]['PlayerName']]; ?></td>
							</tr>
							<tr class="row-item">
								<?php if (count($resultFrame[$value2['FrameID']]) > 0) { ?>
									<?php if ($resultFrame[$value2['FrameID']][1]['FrameScore'] > $resultFrame[$value2['FrameID']][0]['FrameScore']) { ?>
										<td class="item-player-name text-red"><?php echo $inforMatch[1]['PlayerName']; ?></td>
									<?php } else { ?>
										<td class="item-player-name"><?php echo $inforMatch[1]['PlayerName']; ?></td>
									<?php } ?>
								<?php } else { ?>
									<td class="item-player-name"><?php echo $inforMatch[1]['PlayerName']; ?></td>
								<?php } ?>
								<td class="item-result-frame" contenteditable value-player-id="<?php echo $inforMatch[1]['PlayerID']; ?>" value-frame-id="<?php echo $value2['FrameID']; ?>"><?php 
									if (count($resultFrame[$value2['FrameID']]) > 0) {
										echo $resultFrame[$value2['FrameID']][1]['FrameScore']; 
									}
								?></td>
								<td class="item-score"><?php echo $frPlayer[$inforMatch[1]['PlayerName']]; ?></td>
							</tr>
						</tbody>
					</table>
				<?php
							$frameNow++;
						}
					}
				?>
				<div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						Add Frame <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo Yii::app()->createUrl('site/match', array('mID'=>$_GET['mID'], 'act'=>'addframe', 'type'=>'timeline')); ?>">By Timeline</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('site/match', array('mID'=>$_GET['mID'], 'act'=>'addframe', 'type'=>'result')); ?>">By Result</a></li>
					</ul>
				</div>
				<!-- <table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>FRAME <?php //echo $numFrame; ?></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table> -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.item-result-frame').on('keydown', function (e) {
		var obj = $(this);
		var k = e.keyCode || e.charCode;
		if (k == 13) {
			e.preventDefault();
			var pID = obj.attr('value-player-id');
			var fID = obj.attr('value-frame-id');

			obj.blur(function () {
				$(document).focus();
			});
		}
	});
</script>