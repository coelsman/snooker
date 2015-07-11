<?php
class WeatherController extends Controller {
	public $layout = 'client';
	public function actionIndex() {
		$this->render('index');
	}

	public function actionGetListCitiesInMapBound() {
		$northernMost = (double)Yii::app()->request->getQuery('northernMost');
		$southernMost = (double)Yii::app()->request->getQuery('southernMost');
		$westernMost = (double)Yii::app()->request->getQuery('westernMost');
		$easternMost = (double)Yii::app()->request->getQuery('easternMost');
		$listCities = Yii::app()->db->createCommand()
			->select 	('WC.name as CityName, WC.latitude CityLatitude, WC.longtitude CityLongtitude, WC.api_id CityIDService, WC.last_updated LastUpdate, WC.weather_now Weather, WC.country_code CountryCode')
			->from 		('weather_city WC')
			->where 	('WC.latitude > :southernMost AND WC.latitude < :northernMost AND WC.longtitude > :westernMost AND WC.longtitude < :easternMost', array(
				'northernMost' => $northernMost,
				'southernMost' => $southernMost,
				'westernMost' => $westernMost,
				'easternMost' => $easternMost
			))->queryAll();

		for($i=0, $c=count($listCities); $i<$c; $i++) {
			$gettingTime = time();
			if ($gettingTime - $listCities[$i]['LastUpdate'] > 3600) {
				$curl = new CurlFetcher;
				$curl->url = 'http://api.openweathermap.org/data/2.5/weather';
				$curl->query = '?id='.$listCities[$i]['CityIDService'];
				$curlData = $curl->fetchData();

				$listCities[$i]['Weather'] = json_decode($curlData);

				// update data
				$objWeather = WeatherCity::model()->findByAttributes(array('api_id'=>$listCities[$i]['CityIDService']));
				$objWeather->last_updated = $gettingTime;
				$objWeather->weather_now = $curlData;
				$objWeather->update();
			} else {
				$listCities[$i]['Weather'] = json_decode($listCities[$i]['Weather']);
			}
		}
		echo json_encode($listCities);
		
		Yii::app()->end();
	}
}