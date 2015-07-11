<?php

/**
 * This is the model class for table "tournament".
 *
 * The followings are the available columns in table 'tournament':
 * @property string $id
 * @property string $base_name
 * @property integer $status
 */
class Tournament extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tournament';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('base_name, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('base_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, base_name, status', 'safe', 'on'=>'search'),
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
			'base_name' => 'Base Name',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('base_name',$this->base_name,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tournament the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function listTournament() {
		return Yii::app()->db->createCommand()
			->select 	('T.base_name as TournamentName, ST.name as TournamentStatus')
			->from 		('tournament T')
			->join 		('status_tournament ST', 'ST.id = T.status')
			->queryAll 	();
	}

	public function listTournamentBySeason($sID) {
		return Yii::app()->db->createCommand()
			->select 	('ST.season_id as SeasonID, ST.tournament_id as TournamentID, ST.tournament_name as TournamentName, T.base_name as TournamentBaseName, SST.name as TournamentStatus')
			->from 		('tournament T')
			->leftJoin 	('season_tournament ST', 'T.id = ST.tournament_id AND ST.season_id = '.$sID)
			->leftJoin 	('status_season_tournament SST', 'SST.id = ST.status')
			->queryAll 	();
	}
}
