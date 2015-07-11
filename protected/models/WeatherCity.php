<?php

/**
 * This is the model class for table "weather_city".
 *
 * The followings are the available columns in table 'weather_city':
 * @property string $id
 * @property string $name
 * @property string $latitude
 * @property string $longtitude
 * @property string $country_code
 * @property string $api_id
 * @property string $last_updated
 * @property string $weather_now
 */
class WeatherCity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'weather_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, latitude, longtitude, country_code, api_id, last_updated, weather_now', 'required'),
			array('name', 'length', 'max'=>100),
			array('latitude, longtitude, api_id', 'length', 'max'=>10),
			array('country_code', 'length', 'max'=>2),
			array('last_updated', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, latitude, longtitude, country_code, api_id, last_updated, weather_now', 'safe', 'on'=>'search'),
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
			'latitude' => 'Latitude',
			'longtitude' => 'Longtitude',
			'country_code' => 'Country Code',
			'api_id' => 'Api',
			'last_updated' => 'Last Updated',
			'weather_now' => 'Weather Now',
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
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longtitude',$this->longtitude,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('api_id',$this->api_id,true);
		$criteria->compare('last_updated',$this->last_updated,true);
		$criteria->compare('weather_now',$this->weather_now,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WeatherCity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
