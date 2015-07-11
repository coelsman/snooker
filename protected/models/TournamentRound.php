<?php

/**
 * This is the model class for table "tournament_round".
 *
 * The followings are the available columns in table 'tournament_round':
 * @property integer $season_id
 * @property integer $tournament_id
 * @property integer $round_id
 * @property string $round_name
 */
class TournamentRound extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tournament_round';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season_id, tournament_id, round_id', 'required'),
			array('season_id, tournament_id, round_id', 'numerical', 'integerOnly'=>true),
			array('round_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('season_id, tournament_id, round_id, round_name', 'safe', 'on'=>'search'),
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
			'round_id' => 'Round',
			'round_name' => 'Round Name',
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
		$criteria->compare('round_id',$this->round_id);
		$criteria->compare('round_name',$this->round_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TournamentRound the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
