<div class="addframetimeline">
	<?php
		if ($matchPlayer[0]['PlayerImage'] == '') {
			$matchPlayer[0]['PlayerImage'] = 'user-default-avatar.png';
		}
		if ($matchPlayer[1]['PlayerImage'] == '') {
			$matchPlayer[1]['PlayerImage'] = 'user-default-avatar.png';
		}
		if ($matchPlayer[0]['MatchScore'] == '') {
			$matchPlayer[0]['MatchScore'] = 0;
		}
		if ($matchPlayer[1]['MatchScore'] == '') {
			$matchPlayer[1]['MatchScore'] = 0;
		}
	?>
	<?php if (Yii::app()->request->getQuery('type') == 'timeline') { ?>
		<div class="wrap_frame">
			<div class="wrap_avatar_player">
				<div class="avatar_player avatar-1"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$matchPlayer[0]['PlayerImage']; ?>"></div>
				<div class="avatar_player avatar-2"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$matchPlayer[1]['PlayerImage']; ?>"></div>
			</div>
			<div class="wrap_name_player">
				<div class="name_player name-1"><?php echo strtoupper($matchPlayer[0]['PlayerName']); ?></div>
				<div class="name_player name-2"><?php echo strtoupper($matchPlayer[1]['PlayerName']); ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="wrap_win_player">
				<div class="win_player win-1"><?php echo $matchPlayer[0]['MatchScore']; ?></div>
				<div class="win_player win-2"><?php echo $matchPlayer[1]['MatchScore']; ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="wrap_score_player">
				<div class="score_player score-1">
					<div class="number number-1">0</div>
					<div class="number number-2">0</div>
					<div class="number number-3">0</div>
					<div class="clearfix"></div>
				</div>
				<div class="score_player score-2">
					<div class="number number-1">0</div>
					<div class="number number-2">0</div>
					<div class="number number-3">0</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="wrap_pointer_player">
				<div class="pointer_player p1 hide">
					<div class="pointer-1"></div>
				</div>
				<div class="pointer_player p2 hide">
					<div class="pointer-2"></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="wrap_end_frame">
				<div class="end_frame">END FRAME</div>
				<div class="reset_frame">RESET FRAME</div>
			</div>
			<div class="wrap_ball_quantity">
				<div class="ball_quantity"><div class="ball ball-1">15</div></div>
				<div class="point_remain">
					<div class="title">LEFT ON TABLE</div>
					<div class="point">147</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="wrap_frame_detail">
				<div class="detail_player p1">
					<div class="player_name"><?php echo strtoupper($matchPlayer[0]['PlayerName']); ?></div>
					<div class="list_detail_point"></div>
					<div class="clearfix"></div>
				</div>
				<div class="detail_player p2">
					<div class="player_name"><?php echo strtoupper($matchPlayer[1]['PlayerName']); ?></div>
					<div class="list_detail_point"></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="wrap_list_ball">
			<div class="wrap_ball"><div p-value="1" class="ball ball-1">1</div></div>
			<div class="wrap_ball"><div p-value="2" class="ball ball-2">2</div></div>
			<div class="wrap_ball"><div p-value="3" class="ball ball-3">3</div></div>
			<div class="wrap_ball"><div p-value="4" class="ball ball-4">4</div></div>
			<div class="wrap_ball"><div p-value="5" class="ball ball-5">5</div></div>
			<div class="wrap_ball"><div p-value="6" class="ball ball-6">6</div></div>
			<div class="wrap_ball"><div p-value="7" class="ball ball-7">7</div></div>
			<div class="wrap_ball"><div p-value="4" class="ball ball-8"></div></div>
		</div>
		<div class="clearfix"></div>
	<?php } else { ?>
		
	<?php } ?>
	
</div>
<script src="js/ClientWS.js" type="text/javascript"></script>
<script type="text/javascript">
	var wsTimeline;
	function FrameStatic (win1, win2) {
		this.score = [0, win1, win2];
		this.point = [0, 0, 0];
		this.detail = [null, [], []];
		this.pointInARow = [0, 0, 0];
		this.pointerPlayer = 1;
		this.remainBall = 15;
		this.ballStatus = [null, true, true, true, true, true, true, true];
	}
	FrameStatic.prototype.resetData = function () {
		this.point = [0, 0, 0];
		this.detail = [null, {}, {}];
		this.pointInARow = [0, 0, 0];
	}
	FrameStatic.prototype.goalTheBall = function (point) {
		var _opponent = this.getOpponent(this.pointerPlayer);
		this.pointInARow[this.pointerPlayer] += point;
		this.point[this.pointerPlayer] += point;
	}
	FrameStatic.prototype.getOpponent = function (player) {
		if (player === 1) {
			return 2;
		} else {
			return 1;
		}
	}
	FrameStatic.prototype.showPointerPlayer = function () {
		var _opponent = this.getOpponent(this.pointerPlayer);
		$('.wrap_pointer_player p'+this.pointerPlayer).removeClass('hide');
		$('.wrap_pointer_player p'+_opponent).addClass('hide');
	}
	FrameStatic.prototype.switchPointerPlayer = function () {
		if (this.pointInARow[this.pointerPlayer] > 0) {
			var _opponent = this.getOpponent(this.pointerPlayer);
			this.detail[this.pointerPlayer].push(this.pointInARow[this.pointerPlayer]);
			this.detail[_opponent].push('..');
			applyPointInARowToHtml(this.pointerPlayer, this.pointInARow[this.pointerPlayer]);
			applyPointInARowToHtml(_opponent, '..');
			this.pointInARow = [0, 0, 0];
		}
		this.pointerPlayer = (this.pointerPlayer == 1) ? 2 : 1;
	}
	FrameStatic.prototype.divisionStringPoint = function (point) {
		var _n1 = _n2 = n3 = 0;
		var _odd = Math.floor(point / 10);
		_n3 = point % 10;
		if (_odd >= 10) {
			_n2 = _odd % 10;
			_n1 = Math.floor(_odd / 10);
		} else {
			_n2 = _odd;
		}

		return [null, _n1, _n2, _n3];
	}
	FrameStatic.prototype.getRemainPoint = function () {
		if (this.remainBall > 0) {
			return this.remainBall * 8 + 27;
		} else {
			var _rt = 0;
			for (var i=1, c=this.ballStatus.length; i<c; i++) {
				if (this.ballStatus[i] == true) {
					_rt += i;
				}
			}
			return _rt;
		}
	}

	function applyPointToHtml (objFrame, arrPoint) {
		$('.wrap_score_player .score-'+objFrame.pointerPlayer+' .number-'+1).html(arrPoint[1]);
		$('.wrap_score_player .score-'+objFrame.pointerPlayer+' .number-'+2).html(arrPoint[2]);
		$('.wrap_score_player .score-'+objFrame.pointerPlayer+' .number-'+3).html(arrPoint[3]);
	}
	function applyRemainBallToHtml (remainValue) {
		$('.wrap_ball_quantity .ball-1').html(remainValue);
	}
	function applyRemainPointToHtml (objFrame) {
		$('.wrap_ball_quantity .point').html(objFrame.getRemainPoint());
	}
	function updateListBallByBallStatus (objFrame) {
		for (var i=1, c=objFrame.ballStatus.length; i<c; i++) {
			if (objFrame.ballStatus[i] == true) {
				$('.wrap_list_ball .ball-'+i).removeClass('hide');
			} else {
				$('.wrap_list_ball .ball-'+i).addClass('hide');
			}
		}
	}
	function applyPointInARowToHtml (pointerPlayer, value) {
		$('.wrap_frame_detail .p'+pointerPlayer+' .list_detail_point').append('<div class="item">'+value+'</div>');
	}

	$(document).ready(function () {
		var sc1 = $('.wrap_win_player .win-1').html();
		var sc2 = $('.wrap_win_player .win-2').html();

		var frame = new FrameStatic(parseInt(sc1), parseInt(sc2));
		wsTimeline = new ClientWS('ws://127.0.0.2:9300');

		//Let the user know we're connected
		wsTimeline.bind('open', function() {
			console.info("Connected.");
		});

		//OH NOES! Disconnection occurred.
		wsTimeline.bind('close', function( data ) {
			console.info("Disconnected.");
		});

		//Log any messages sent from server
		wsTimeline.bind('message', function (payload) {
			console.info(payload);
		});

		wsTimeline.connect();

		$('.wrap_pointer_player .pointer_player.p'+frame.pointerPlayer).removeClass('hide');

		$('.wrap_list_ball .ball').on('click', function () {
			var _p = $(this).attr('p-value'), _arrNumberInPoint;
			if (_p == '1') {
				frame.remainBall--;
			}
			if (frame.remainBall <= 0) {
				frame.remainBall = 0;
				if (frame.ballStatus[1] == true) {
					frame.ballStatus[1] = false;
				} else {

				}
			}
			updateListBallByBallStatus(frame);
			frame.goalTheBall(parseInt(_p), frame.pointerPlayer);
			_arrNumberInPoint = frame.divisionStringPoint(frame.point[frame.pointerPlayer]);
			applyPointToHtml(frame, _arrNumberInPoint);
			applyRemainBallToHtml(frame.remainBall);
			applyRemainPointToHtml(frame);
			wsTimeline.send('message', JSON.stringify({
				'score': frame.score,
				'point': frame.point,
				'inARow': frame.pointInARow
			}));
		});

		$('.wrap_pointer_player .pointer_player').on('click', function () {
			$('.wrap_pointer_player .pointer_player').addClass('hide');
			frame.switchPointerPlayer();
			$('.wrap_pointer_player .pointer_player.p'+frame.pointerPlayer).removeClass('hide');
		});

		$('.wrap_end_frame .end_frame').on('click', function () {
			console.log(frame.detail);
		});
	});
</script>