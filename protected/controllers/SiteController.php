<?php

class SiteController extends Controller
{
	public $statusPlayer = array(
		'Active' => 'label-success'
	);
	public $statusSeason = array(
		'Active' => 'label-success'
	);
	public $statusTournament = array(
		'Active' => 'label-success'
	);
	public $statusSeasonTournament = array(
		'Not Started' => 'label-default',
		'In Progress' => 'label-success',
		'Finished' => 'label-warning',
		'Locked' => 'label-danger'
	);
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionPlayer() {
		if (Yii::app()->request->getQuery('page')) {
			$page = Yii::app()->request->getQuery('page');
		} else {
			$page = 1;
		}
		$data = Player::model()->listPlayer($page);
		$listNational = National::model()->findAll(array('order'=>'name asc'));
		$countPlayer = PLayer::model()->count();
		$this->render('player', array(
			'data' => $data,
			'arrStatus' => $this->statusPlayer,
			'listNational' => $listNational,
			'countPlayer' => $countPlayer
		));
	}

	public function actionSeason() {
		if (Yii::app()->request->getQuery('t') == 'tournament') {
			$season_id = Yii::app()->request->getQuery('sID');
			$seasonData = Season::model()->getSeasonById($season_id);	
			$data = Tournament::model()->listTournamentBySeason($season_id);

			$this->render('seasonTournament', array(
				'data' => $data,
				'season' => $seasonData,
				'arrStatus' => $this->statusSeasonTournament
			));
			die;
		}

		if (Yii::app()->request->getQuery('sID') && Yii::app()->request->getQuery('tID') && Yii::app()->request->getQuery('rID')) {
			if (Yii::app()->request->getQuery('page')) {
				$page = Yii::app()->request->getQuery('page');
			} else {
				$page = 1;
			}
			$season_id = Yii::app()->request->getQuery('sID');
			$tournament_id = Yii::app()->request->getQuery('tID');
			$round_id = Yii::app()->request->getQuery('rID');

			$seasonData = Season::model()->getSeasonById($season_id);
			$tournamentData = SeasonTournament::model()->findByAttributes(array('tournament_id'=>$tournament_id));
			$roundData = Round::model()->getRoundBySeasonTournament($season_id, $tournament_id, $round_id);
			$listMatch = Match::model()->listMatchByRound($season_id, $tournament_id, $round_id, $page);
			$activeUserByTournament = Player::model()->getActiveUserByTournament($season_id, $tournament_id);

			$this->render('round', array(
				'season' => $seasonData,
				'tournament' => $tournamentData,
				'round' => $roundData,
				'listMatch' => $listMatch,
				'activeUser' => $activeUserByTournament
			));
			die;
		} else {
			if (Yii::app()->request->getQuery('tID')) {
				if (Yii::app()->request->getQuery('pagePlayer')) {
					$pagePlayer = Yii::app()->request->getQuery('pagePlayer');
				} else {
					$pagePlayer = 1;
				}
				$season_id = Yii::app()->request->getQuery('sID');
				$tournament_id = Yii::app()->request->getQuery('tID');
				$seasonData = Season::model()->getSeasonById($season_id);
				$tournamentData = SeasonTournament::model()->findByAttributes(array('tournament_id'=>$tournament_id));
				$listPlayer = Player::model()->getPlayerBySeasonTournament($season_id, $tournament_id, $pagePlayer);
				$listRound = Round::model()->getRoundBySeasonTournament($season_id, $tournament_id);
				$listPrize = Position::model()->getPrizeBySeasonTournament($season_id, $tournament_id);
				$centuryBreak = SeasonTournament::model()->listCenturyBySeasonTournament($season_id, $tournament_id);
				// var_dump($centuryBreak); die;

				$totalPage = 5;
				$this->render('updateSeasonTournament', array(
					'season' => $seasonData,
					'listPlayer' => $listPlayer,
					'tournament' => $tournamentData,
					'listRound' => $listRound,
					'listPrize' => $listPrize,
					'centuryBreak' => $centuryBreak,
					'pagination' => array(
						'totalPage' => $totalPage
					)
				));
				die;
			}
		}

		$data = Season::model()->listSeason();
		$this->render('season', array(
			'data' => $data,
			'arrStatus' => $this->statusSeason
		));
	}

	public function actionTournament() {
		$data = Tournament::model()->listTournament();
		$this->render('tournament', array(
			'data' => $data,
			'arrStatus' => $this->statusTournament
		));
	}

	public function actionRound() {
		
	}

	public function actionMatch() {
		if (Yii::app()->request->getQuery('mID')) {
			$match_id = Yii::app()->request->getQuery('mID');
			if (Yii::app()->request->getQuery('act')) {
				$action = Yii::app()->request->getQuery('act');
				$type = Yii::app()->request->getQuery('type');
				if ($action == 'addframe') {
					$matchPlayer = Yii::app()->db->createCommand()
						->select 	('MP.score as MatchScore, P.name as PlayerName, MP.player_id as PlayerID, P.image as PlayerImage')
						->from 		('match as M')
						->join 		('match_player as MP', 'MP.match_id = M.id')
						->join 		('player as P', 'P.id = MP.player_id')
						->where 	('M.id = :id', array('id'=>$match_id))
						->queryAll 	();
					if ($type == 'result') {
						$this->render('addframe', array(
							'matchPlayer' => $matchPlayer
						));
					} else {
						$this->render('addframetimeline', array(
							'matchPlayer' => $matchPlayer
						));
					}
				}
			} else {
				$matchData = Match::model()->getMatchById($match_id);
				$this->render('match', array(
					'matchData' => $matchData
				));
			}
		} else {
			$listMatch = Match::model()->listAllMatch();
			$this->render('matchall', array(
				'listMatch' => $listMatch
			));
		}
	}

	public function actionAssignPlayerTournament() {
		$sID = Yii::app()->request->getPost('sID');
		$tID = Yii::app()->request->getPost('tID');
		$pID = Yii::app()->request->getPost('pID');

		$checkExist = TournamentPlayer::model()->findByAttributes(array(
			'season_id' => $sID,
			'tournament_id' => $tID,
			'player_id' => $pID
		));

		if ($checkExist == NULL) {
			$obj = new TournamentPlayer;
			$obj->season_id = $sID;
			$obj->tournament_id = $tID;
			$obj->player_id = $pID;
			$obj->save();
			echo SnookerResponse::OK;
		} else {
			echo SnookerResponse::EXIST;
		}
		die;
	}

	public function actionRemovePlayerTournament() {
		$sID = Yii::app()->request->getPost('sID');
		$tID = Yii::app()->request->getPost('tID');
		$pID = Yii::app()->request->getPost('pID');

		$checkExist = TournamentPlayer::model()->findByAttributes(array(
			'season_id' => $sID,
			'tournament_id' => $tID,
			'player_id' => $pID
		));

		if ($checkExist == NULL) {
			echo SnookerResponse::FAIL;
		} else {
			$checkExist->delete();
			echo SnookerResponse::OK;
		}
		die;
	}

	public function actionAssignRoundTournament() {
		$sID    = Yii::app()->request->getPost('sID');
		$tID    = Yii::app()->request->getPost('tID');
		$rID    = Yii::app()->request->getPost('rID');
		$rName  = Yii::app()->request->getPost('rName');
		$raceTo = Yii::app()->request->getPost('raceTo');
		$checkExist = TournamentRound::model()->findByAttributes(array(
			'season_id' => $sID,
			'tournament_id' => $tID,
			'round_id' => $rID
		));

		if ($checkExist == NULL) {
			$obj = new TournamentRound;
			$obj->season_id = $sID;
			$obj->tournament_id = $tID;
			$obj->round_id = $rID;
			if ($rName != '') {
				$obj->round_name = $rName;
			}
			$obj->race_to = $raceTo;
			$obj->save();
			echo SnookerResponse::OK;
		} else {
			echo SnookerResponse::FAIL;
		}
		die;
	}

	public function actionRemoveRoundTournament() {
		$sID   = Yii::app()->request->getPost('sID');
		$tID   = Yii::app()->request->getPost('tID');
		$rID   = Yii::app()->request->getPost('rID');

		$checkExist = TournamentRound::model()->findByAttributes(array(
			'season_id' => $sID,
			'tournament_id' => $tID,
			'round_id' => $rID
		));

		if ($checkExist == NULL) {
			echo SnookerResponse::FAIL;
		} else {
			$checkExist->delete();
			echo SnookerResponse::OK;
		}
		die;
	}

	public function actionCreateMatch() {
		$sID   = Yii::app()->request->getPost('sID');
		$tID   = Yii::app()->request->getPost('tID');
		$rID   = Yii::app()->request->getPost('rID');
		$pl1   = Yii::app()->request->getPost('pl1');
		$pl2   = Yii::app()->request->getPost('pl2');

		// $transaction = Yii::app()->db->beginTransaction();
		try {
			$objMatch = new Match;
			$objMatch->season_id = $sID;
			$objMatch->tournament_id = $tID;
			$objMatch->round_id = $rID;
			$objMatch->created_date = time();
			$objMatch->status = 1;

			if ($objMatch->save()) {
				$id = $objMatch->id;
				$objMatchPlayer1 = new MatchPlayer;
				$objMatchPlayer1->match_id = $id;
				$objMatchPlayer1->player_id = $pl1;

				$objMatchPlayer2 = new MatchPlayer;
				$objMatchPlayer2->match_id = $id;
				$objMatchPlayer2->player_id = $pl2;

				if ($objMatchPlayer1->save() && $objMatchPlayer2->save()) {
					echo SnookerResponse::OK;
				} else {
					$transaction->rollBack();
					echo SnookerResponse::FAIL;
				}
			} else {
				echo SnookerResponse::FAIL;
			}

			// $transaction->commit();
		} catch (Exception $e) {
			// $transaction->rollBack();
		}
		die;
	}

	public function actionAddPlayer () {
		if (Yii::app()->request->getPost('pName') && Yii::app()->request->getPost('nID')) {
			$pName = Yii::app()->request->getPost('pName');
			$nID = Yii::app()->request->getPost('nID');

			$checkName = Player::model()->findByAttributes(array('name'=>$pName));
			if ($checkName) {
				echo SnookerResponse::EXIST;
				die;
			}

			$objPlayer = new Player;
			$objPlayer->name = $pName;
			$objPlayer->national_id = $nID;
			$objPlayer->image = '';
			$objPlayer->status = 1;
			$objPlayer->date_of_birth = 1;
			if ($objPlayer->save()) {
				echo SnookerResponse::OK;
			} else {
				echo SnookerResponse::FAIL;
			}
			die;
		}
	}

	public function actionUpdateScoreMatch() {
		$mID = Yii::app()->request->getPost('mID');
		$score1 = Yii::app()->request->getPost('score1');
		$score2 = Yii::app()->request->getPost('score2');
		$pID1 = Yii::app()->request->getPost('pID1');
		$pID2 = Yii::app()->request->getPost('pID2');
		
		$obj1 = MatchPlayer::model()->findByAttributes(array('match_id'=>$mID, 'player_id'=>$pID1));
		if ($obj1) {
			$obj1->score = $score1;
			$obj1->save();
		}

		$obj2 = MatchPlayer::model()->findByAttributes(array('match_id'=>$mID, 'player_id'=>$pID2));
		if ($obj2) {
			$obj2->score = $score2;
			$obj2->save();
		}

		echo SnookerResponse::OK;
	}

	public function actionAddFrameResult() {
		$mID = Yii::app()->request->getPost('mID');
		$dataPost = Yii::app()->request->getPost('dataPost');
		$pID1 = Yii::app()->request->getPost('pID1');
		$pID2 = Yii::app()->request->getPost('pID2');
		// echo $pID1.'-'.$pID2; die;
		// echo $mID;
		// var_dump($dataPost); die;
		// add frame to the match and get frame's ID
		$objFrame = new Frame;
		$objFrame->match_id = $mID;
		$objFrame->status = 1;
		if ($objFrame->save()) {
			// $transaction = Yii::app()->db->beginTransaction();
			try {
				$totalScore = array(
					$pID1 => 0,
					$pID2 => 0
				);
				$fID = $objFrame->id;
				foreach ($dataPost as $key => $value) {
					$objDetail = new FrameDetail;
					$objDetail->frame_id = $fID;
					$objDetail->player_id = $value['pID'];
					$objDetail->result_score = $value['point'];
					$objDetail->status = 1;
					$objDetail->save();

					$totalScore[$value['pID']] += $value['point'];
				}
				foreach ($totalScore as $key => $value) {
					$objTotal = new FrameResult;
					$objTotal->frame_id = $fID;
					$objTotal->player_id = $key;
					$objTotal->result_score = $value;
					$objTotal->status = 1;
					$objTotal->save();
				}

				if ($totalScore[$pID1] > $totalScore[$pID2]) {
					$largerVal = $pID1;
					$smallerVal = $pID2;
				} else {
					$largerVal = $pID2;
					$smallerVal = $pID1;
				}

				$objMatchPlayer1 = MatchPlayer::model()->findByAttributes(array('match_id'=>$mID, 'player_id'=>$largerVal));
				$objMatchPlayer2 = MatchPlayer::model()->findByAttributes(array('match_id'=>$mID, 'player_id'=>$smallerVal));

				if ($objMatchPlayer1->score == NULL && $objMatchPlayer2->score == NULL) {
					$objMatchPlayer1->score = 1;
					$objMatchPlayer2->score = 0;
				} else {
					$objMatchPlayer1->score++;
				}

				if ($objMatchPlayer1->update() && $objMatchPlayer2->update()) {
					echo SnookerResponse::OK;
					die;
				}

				// $transaction->commit();
			} catch (Exception $e) {
				// $transaction->rollBack();
			}


			echo SnookerResponse::OK;
		}

		die;
	}
}