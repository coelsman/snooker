<!-- test commit github -->
<style type="text/css">
	#content-left, 
	#content-right {
		display: none;
	}
	#content-center {
		width: 100%;
		margin: auto;
	}
	
	#weather-city {
		min-height: 200px;
	}
	#weather-city #map-city {
		float: right;
		width: 35%; height: 240px;
		margin-right: 3%;
	}
	#weather-city .wrap-generality-infor {
		float: right;
		width: 59%;
		margin-left: 3%;
	}
	#weather-city .wrap-generality-infor {}
	#weather-city .wrap-generality-infor {}
	#weather-city .wrap-generality-infor {}
	#weather-city {}
</style>

<div id="weather-city">
	<div id="map-city"></div>
	<div class="wrap-generality-infor">
		<div class="city-name"><?php echo $dataCity['CityName']; ?></div>
		<div class="city-country"></div>
		<input type="hidden" class="city-country-code" value="<?php echo $dataCity['CountryCode']; ?>">
		<div class="city-weather-last-updated"><?php echo gmdate("d/m/Y H:i:s", $dataCity['LastUpdate']); ?></div>
		<div class="wrap-coordinates">
			<div class="city-latitude"><?php echo $dataCity['CityLatitude']; ?></div>
			<div class="city-longtitude"><?php echo $dataCity['CityLongtitude']; ?></div>
		</div>
		<div class="city-weather-icon"><img src="<?php echo Yii::app()->request->baseUrl.'/images/weather/'.$dataCity['Weather']->weather[0]->icon.'.png'; ?>"></div>
	</div>
	<div class="wrap_forecast">

	</div>
</div>

<script src="http://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/markerwithlabel.min.js"></script>
<script type="text/javascript">
	(function () {

	})()
</script>