<?php
class MapController extends Controller {
	public $layout = 'client';

	public function actionIndex() {
		$this->render('index', array(

		));
	}

	public function actionGetDataCities() {
		$dataCities = Yii::app()->db->createCommand()
			->select 	('*')
			->from 		('map_city MC')
			->queryAll 	();
		echo json_encode($dataCities);
		die;
	}

	public function actionUpdateCoordinates() {
		$lat = Yii::app()->request->getPost('latitude');
		$lng = Yii::app()->request->getPost('longtitude');
		$city_id = Yii::app()->request->getPost('id');
		$zoom = Yii::app()->request->getPost('zoom');
		$objCity = MapCity::model()->findByPk($city_id);
		$objCity->latitude = $lat;
		$objCity->longtitude = $lng;
		$objCity->zoom = $zoom;
		if ($objCity->update()) {
			echo json_encode(array('status'=>'OK', 'message'=>''));
		} else {
			echo json_encode(array('status'=>'FAIL', 'message'=>''));
		}
		die;
	}

	public function actionAddMap() {
		var_dump($_POST);
	}
}
?>