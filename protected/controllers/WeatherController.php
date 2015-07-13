<?php
class WeatherController extends Controller {
	public $layout = 'client';
	public function actionIndex() {
		$this->render('index');
	}

	public function actionCity() {
		if (Yii::app()->request->getQuery('id')) {
			$dataCity = Yii::app()->db->createCommand()
				->select 	('WC.name as CityName, WC.latitude CityLatitude, WC.longtitude CityLongtitude,'.
					' WC.api_id CityIDService, WC.last_updated LastUpdate, WC.weather_now Weather, WC.country_code CountryCode,'.
					' WC.last_updated_forecast LastUpdateForecast, WC.forecast_5 Forecast5')
				->from 		('weather_city WC')
				->where 	('WC.api_id = :id', array(
					'id' => Yii::app()->request->getQuery('id')
				))->queryRow();
			$gettingTime = time();
			$dataCity['Weather'] = json_decode($dataCity['Weather']);

			if ($gettingTime - $dataCity['LastUpdateForecast'] > 10800) {
				$curl = new CurlFetcher;
				$curl->url = 'http://api.openweathermap.org/data/2.5/forecast';
				$curl->query = '?id='.$dataCity['CityIDService'];
				$curlData = $curl->fetchData();

				$dataCity['Forecast5'] = json_decode($curlData);

				$objWeather = WeatherCity::model()->findByAttributes(array('api_id'=>$dataCity['CityIDService']));
				$objWeather->last_updated_forecast = $gettingTime;
				$objWeather->forecast_5 = $curlData;
				$objWeather->update();
			} else {
				$dataCity['Forecast5'] = json_decode($dataCity['Forecast5']);
			}

			$this->render('city', array(
				'dataCity' => $dataCity
			));
		} else {
			// $this->render('//404/index');
		}
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