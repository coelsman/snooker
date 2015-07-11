<?php

/**
 * This is the model class for table "round".
 *
 * The followings are the available columns in table 'round':
 * @property string $id
 * @property string $base_name
 * @property integer $number_player
 */
class Round extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'round';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('base_name, number_player', 'required'),
			array('number_player', 'numerical', 'integerOnly'=>true),
			array('base_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, base_name, number_player', 'safe', 'on'=>'search'),
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
			'number_player' => 'Number Player',
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
		$criteria->compare('number_player',$this->number_player);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Round the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getRoundBySeasonTournament($sID, $tID, $rID = '') {
		if ($rID == '') {
			return Yii::app()->db->createCommand()
				->select 	('D.id as RoundID, D.base_name as RoundBaseName, TR.season_id as SeasonID, TR.tournament_id as TournamentID, TR.round_name as RoundName, TR.race_to as RaceTo')
				->from 		('round D')
				->leftJoin 	('tournament_round TR', 'TR.round_id = D.id AND TR.season_id = '.$sID.' AND TR.tournament_id = '.$tID)
				->queryAll 	();
		} else {
			return Yii::app()->db->createCommand()
			->select 	('D.id as RoundID, D.base_name as RoundBaseName, TR.season_id as SeasonID, TR.tournament_id as TournamentID, TR.round_name as RoundName, TR.race_to as RaceTo')
			->from 		('round D')
			->leftJoin 	('tournament_round TR', 'TR.round_id = D.id AND TR.season_id = '.$sID.' AND TR.tournament_id = '.$tID)
			->where 	('D.id = :id', array('id'=>$rID))
			->queryRow 	();
		}
	}
}
