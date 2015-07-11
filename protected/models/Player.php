<?php

/**
 * This is the model class for table "player".
 *
 * The followings are the available columns in table 'player':
 * @property string $id
 * @property string $name
 * @property integer $national_id
 * @property string $image
 * @property integer $status
 * @property string $date_of_birth
 */
class Player extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, national_id, status, date_of_birth', 'required'),
			array('national_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('image', 'length', 'max'=>1000),
			array('date_of_birth', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, national_id, image, status, date_of_birth', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'national_id' => 'National',
			'image' => 'Image',
			'status' => 'Status',
			'date_of_birth' => 'Date Of Birth',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('national_id',$this->national_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Player the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function listPlayer($page) {
		$limit = 15;
		$offset = ($page - 1) * $limit;
		return Yii::app()->db->createCommand()
			->select 	('P.id as PlayerID, P.name as PlayerName, N.name as NationalName, SP.name as StatusName')
			->from 		('player as P')
			->join 		('national as N', 'N.id = P.national_id')
			->join 		('status_player as SP', 'SP.id = P.status')
			->order 	('P.name asc')
			->limit 	($limit, $offset)
			->queryAll 	();
	}

	public function getPlayerBySeasonTournament($sID, $tID, $page) {
		$limit = 15;
		$offset = ($page - 1) * $limit;
		return Yii::app()->db->createCommand()
			->select 	('P.id as PlayerID, P.name as PlayerName, P.image as PlayerImage, TP.season_id as SeasonID, TP.tournament_id as TournamentID')
			->from 		('player P')
			->leftJoin 	('tournament_player TP', 'TP.player_id = P.id AND season_id = '.$sID.' AND tournament_id = '.$tID)
			->order 	('PlayerName asc')
			->limit 	($limit, $offset)
			->queryAll 	();
	}

	public function getActiveUserByTournament($sID, $tID) {
		return Yii::app()->db->createCommand()
			->select 	('P.id as PlayerID, P.name as PlayerName')
			->from 		('tournament_player TP')
			->leftJoin 	('player P', 'TP.player_id = P.id')
			->where 	('TP.season_id = :sID AND TP.tournament_id = :tID', array('sID'=>$sID, 'tID'=>$tID))
			->order 	('P.name asc')
			->queryAll 	();
	}
}
