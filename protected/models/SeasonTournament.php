<?php

/**
 * This is the model class for table "season_tournament".
 *
 * The followings are the available columns in table 'season_tournament':
 * @property integer $season_id
 * @property integer $tournament_id
 * @property string $tournament_name
 * @property integer $status
 */
class SeasonTournament extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'season_tournament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season_id, tournament_id, status', 'required'),
			array('season_id, tournament_id, status', 'numerical', 'integerOnly'=>true),
			array('tournament_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('season_id, tournament_id, tournament_name, status', 'safe', 'on'=>'search'),
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
			'season_id' => 'Season',
			'tournament_id' => 'Tournament',
			'tournament_name' => 'Tournament Name',
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

		$criteria->compare('season_id',$this->season_id);
		$criteria->compare('tournament_id',$this->tournament_id);
		$criteria->compare('tournament_name',$this->tournament_name,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeasonTournament the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function listCenturyBySeasonTournament($sID, $tID) {
		return Yii::app()->db->createCommand()
			->select 	('P.id as PlayerID, P.name as PlayerName, R.base_name RoundName, FD.result_score ResultScore')
			->from 		('match M')
			->join 		('frame F', 'F.match_id = M.id')
			->join 		('frame_detail FD', 'FD.frame_id = F.id')
			->join 		('player P', 'P.id = FD.player_id')
			->join 		('round R', 'R.id = M.round_id')
			->where 	('M.season_id = :sID AND M.tournament_id = :tID AND FD.result_score >= 100', array('sID'=>$sID, 'tID'=>$tID))
			->order 	('FD.result_score desc')
			->queryAll 	();
	}
}
