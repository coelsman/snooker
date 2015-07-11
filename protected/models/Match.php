<?php

/**
 * This is the model class for table "match".
 *
 * The followings are the available columns in table 'match':
 * @property integer $id
 * @property integer $season_id
 * @property integer $tournament_id
 * @property integer $round_id
 * @property string $created_date
 * @property integer $status
 */
class Match extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'match';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season_id, tournament_id, round_id, created_date, status', 'required'),
			array('season_id, tournament_id, round_id, status', 'numerical', 'integerOnly'=>true),
			array('created_date', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, season_id, tournament_id, round_id, created_date, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'season_id' => 'Season',
			'tournament_id' => 'Tournament',
			'round_id' => 'Round',
			'created_date' => 'Created Date',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('season_id',$this->season_id);
		$criteria->compare('tournament_id',$this->tournament_id);
		$criteria->compare('round_id',$this->round_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Match the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function listAllMatch() {
		return Yii::app()->db->createCommand()
			->select 	('P.id PlayerID, P.name PlayerName, MP.score Score, ST.tournament_name TournamentName')
			->from 		('match M')
			->join 		('match_player MP', 'MP.match_id = M.id')
			->join 		('player P', 'P.id = MP.player_id')
			->join 		('season_tournament ST', 'ST.season_id = M.season_id AND ST.tournament_id = M.tournament_id')
			->queryAll 	();
	}

	public function listMatchesByStatus($status) {
		return Yii::app()->db->createCommand()
			->select 	('M.id MatchID, P.id PlayerID, P.name PlayerName, MP.score Score, ST.tournament_name TournamentName')
			->from 		('match M')
			->join 		('match_player MP', 'MP.match_id = M.id')
			->join 		('player P', 'P.id = MP.player_id')
			->join 		('season_tournament ST', 'ST.season_id = M.season_id AND ST.tournament_id = M.tournament_id')
			->where 	('M.status = :status', array('status'=>$status))
			->order 	('ST.tournament_id desc')
			->queryAll 	();
	}

	public function listMatchByRound($sID, $tID, $rID, $p) {
		$limit = 20;
		$offset = ($p - 1) * $limit;
		return Yii::app()->db->createCommand()
			->select 	('M.id as MatchID, P.name as PlayerName, MP.score as MatchScore, P.id as PlayerID')
			->from 		('match as M')
			// ->join 		('status_match as SM', 'M.status = SM.id')
			->join 		('match_player as MP', 'MP.match_id = M.id')
			->join 		('player as P', 'P.id = MP.player_id')
			->where 	('M.season_id = :season_id AND tournament_id = :tournament_id AND round_id = :round_id', array(
				'season_id' => $sID,
				'tournament_id' => $tID,
				'round_id' => $rID
			))
			// ->limit 	($limit, $offset)
			->queryAll 	();
	}

	public function getMatchById($mID) {
		$match = [];
		$match['infor'] =  Yii::app()->db->createCommand()
			->select 	('MP.score as MatchScore, P.name as PlayerName, MP.player_id as PlayerID')
			->from 		('match as M')
			->join 		('match_player as MP', 'MP.match_id = M.id')
			->join 		('player as P', 'P.id = MP.player_id')
			->where 	('M.id = :id', array('id'=>$mID))
			->queryAll 	();
		$listFrameId = Frame::model()->findAllByAttributes(array('match_id'=>$mID));
		if ($listFrameId) {
			foreach ($listFrameId as $key => $value) {
				$match['detail'][$value->id] = Yii::app()->db->createCommand()
					->select 	('P.name, FD.result_score as FrameScore, FD.frame_id as FrameID')
					->from 		('frame_detail as FD')
					->join 		('player as P', 'P.id = FD.player_id')
					->where 	('FD.frame_id = :id', array('id'=>$value->id))
					->order 	('FD.id asc')
					->queryAll 	();
				$match['result_frame'][$value->id] = Yii::app()->db->createCommand()
					->select 	('P.name as PlayerName, FR.frame_id as FrameID, FR.player_id as PlayerID, FR.result_score as FrameScore')
					->from 		('frame_result as FR')
					->join 		('player as P', 'P.id = FR.player_id')
					->where 	('FR.frame_id = :id', array('id'=>$value->id))
					->queryAll 	();
			}
		} else {
			$match['detail'] = [];
			$match['result_frame'] = [];
		}
		/*if ($match['infor'][0] && $match['infor'][1]) {
			$match['detail'] =  Yii::app()->db->createCommand()
				->select 	('F.id as FrameID, P.name as PlayerName, FS.result_score as FrameScore, FD.result_score as FrameDetail')
				->from 		('frame as F')
				->join 		('frame_result as FS', 'FS.frame_id = F.id')
				->join 		('frame_detail as FD', 'FD.frame_id = F.id')
				->join 		('player as P', 'P.id = FS.player_id AND P.id = FD.player_id')
				->where 	('F.match_id = :id', array('id'=>$mID))
				->queryAll 	();
		} else {
			$match['detail'] = [];
		}*/
		return $match;
	}
}
