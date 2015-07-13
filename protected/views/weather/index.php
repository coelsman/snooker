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
	#weather-index {
		min-height: 700px;
	}
	#weather-index #weather-map {
		width: 100%; height: 600px;
	}
	#weather-index .gm-style-iw + div {
		right: -8px !important; 
		top: -10px !important;
		border: 4px solid #33c;
		border-radius: 11px;
		box-shadow: 0 0 5px #3990b9;
		opacity: 1 !important;
		width: 21px !important;
		height: 21px !important;
	}
	#weather-index .gm-style-iw {
		/*width: 100% !important;*/
		height: auto !important;
		top: 0 !important;
		left: 0 !important;
		max-height: 50px;
		overflow: visible !important;
	}
	#weather-index .gm-style-iw >:first-child {
		max-width: 100% !important;
		overflow: visible !important;
		width: 100% !important;
	}
	#weather-index .gm-style-iw >:first-child >:first-child {
		overflow: visible !important;
	}

	#weather-index .temp-city {
		padding: 3px 7px;
		line-height: 16px;
		opacity: 1 !important;
		font-size: 12px;
		font-weight: bold;
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#bfd255+0,8eb92a+50,72aa00+51,9ecb2d+100;Green+Gloss */
		background: rgb(191,210,85); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(191,210,85,1) 0%, rgba(142,185,42,1) 50%, rgba(114,170,0,1) 51%, rgba(158,203,45,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(191,210,85,1)), color-stop(50%,rgba(142,185,42,1)), color-stop(51%,rgba(114,170,0,1)), color-stop(100%,rgba(158,203,45,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(191,210,85,1) 0%,rgba(142,185,42,1) 50%,rgba(114,170,0,1) 51%,rgba(158,203,45,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(191,210,85,1) 0%,rgba(142,185,42,1) 50%,rgba(114,170,0,1) 51%,rgba(158,203,45,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(191,210,85,1) 0%,rgba(142,185,42,1) 50%,rgba(114,170,0,1) 51%,rgba(158,203,45,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom,  rgba(191,210,85,1) 0%,rgba(142,185,42,1) 50%,rgba(114,170,0,1) 51%,rgba(158,203,45,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfd255', endColorstr='#9ecb2d',GradientType=0 ); /* IE6-9 */

	}

	.weather-city-info {
		width: 285px; height: 70px;
		position: relative;
		padding: 8px 10px;
		border: 5px solid #3333CC;
		border-radius: 7px;
	}
	.weather-city-info .city-name {
		font-size: 14px;
  		font-weight: 500;
	}
	.weather-city-info .city-name a {
		text-decoration: none;
		color: #222;
		cursor: pointer;
		display: block;
	}
	.weather-city-info .city-name:hover a {
		color: #44b;
		text-decoration: underline;
		cursor: pointer;
	}
	.weather-city-info .national-name {
		font-size: 13px;
  		color: #777;
  		margin-bottom: 40px;
	}
	.weather-city-info .temperature {
		position: absolute;
		right: 8px; top: 35px;
	}
	.weather-city-info .temperature-c, 
	.weather-city-info .temperature-f,
	.weather-city-info .humidity {
		color: #fff;
		padding: 3px 5px;
		border-radius: 4px;
		font-size: 12px;
		font-weight: 500;
	}
	.weather-city-info .temperature-c {
		background-color: #33c;
		margin-right: 4px;
	}
	.weather-city-info .temperature-f {
		background-color: #c33;
	}
	.weather-city-info .humidity {
		position: absolute;
		top: 7px; right: 9px;
		background-color: #fa4;
	}
	.weather-city-info .weather-icon {
		position: absolute;
		top: -4px; right: 45px;
	}
	.weather-city-info {
		
	}
	.weather-city-info {
		
	}
</style>

<div id="weather-index">
	<div id="weather-map"></div>
</div>

<script src="http://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/markerwithlabel.min.js"></script>
<script type="text/javascript">
	function Map () {
		this.elementHTML = document.getElementById('weather-map');
		this.options = {
			lat: 10,
			lng: 106, 
			zoom: 13
		};
		this.map = {};
		this.markers = [];
		this.citiesMarkers = [];
		this.largestAreaActive = {};
		this.manageCityMarkerID = [];
	}
	Map.prototype = {
		init: function () {
			var mapOptions = {
				center: new google.maps.LatLng(this.options.lat, this.options.lng),
				zoom: this.options.zoom
			};
			this.map = new google.maps.Map(this.elementHTML, mapOptions);
		},
		drawMarker: function (lat, lng, icon) {
			var _marker = new google.maps.Marker({
			    position: new google.maps.LatLng(lat, lng),
			});
			_marker.setMap(this.map);
			this.markers.push(_marker);
		},
		removeMarker: function (id) {
			this.markers[id].setMap(null);
			this.markers.splice(id, 1);
		},
		drawCityMarker: function (lat, lng, icon, content) {
			var _objMap = this;
			var _marker = new MarkerWithLabel({
				icon: icon,
			    position: new google.maps.LatLng(lat, lng),
			    opacity: 1,
			    draggable: false,
			    raiseOnDrag: false,
			    labelContent: content,
			    map: _objMap.map,
			    labelAnchor: new google.maps.Point(26, 25),
			    labelClass: 'temp-city', 
		    });

			this.citiesMarkers.push(_marker);
			return _marker;
		},
		createPopupCityWeather: function (cityData) {
			var _objMap = this;
			var _lat = parseFloat(cityData.CityLatitude);
			var _lng = parseFloat(cityData.CityLongtitude);
			var _temp_c = cityData.Weather.main.temp - 273.15;
			var _content = '<div class="weather-city-info">' +
				'<div class="city-name"><a href="'+baseUrl+'weather/city&id='+cityData.CityIDService+'">'+cityData.CityName+'</a></div>' + 
				'<div class="national-name">'+countryCode.getCountryByCode(cityData.CountryCode)+'</div>' + 
				'<div class="temperature">' + 
					'<span class="temperature-c">'+_temp_c.toFixed(2)+' &ordm;C</span>' + 
					'<span class="temperature-f">'+cityData.Weather.main.temp.toFixed(2)+' &ordm;K</span>' + 
				'</div>' + 
				'<div class="humidity">'+cityData.Weather.main.humidity+'%</div>' + 
				'<div class="weather-icon"><img src="images/weather/'+cityData.Weather.weather[0].icon+'.png"></div>' + 
			'</div>';

			var _mk = this.drawCityMarker(_lat, _lng, '.', _temp_c.toFixed(2) + '&ordm;C');

			var _infowindow = new google.maps.InfoWindow({
				maxWidth: 232
			});

			google.maps.event.addListener(_mk, 'click', function() {
				_infowindow.setContent(_content);
				_infowindow.close();
				_infowindow.open(_objMap.map, _mk);
				_objMap.manageCityMarkerID.push(cityData.CityIDService);
			});
		},
		didCityGetData: function (id) {
			if (this.manageCityMarkerID.indexOf(id) !== -1) {
				return true;
			}
			return false;
		},
		updateMapBound: function (objBound) {
			var _ne = objBound.getNorthEast();
			var _sw = objBound.getSouthWest();
			this.largestAreaActive.northernMost = _ne.lat();
			this.largestAreaActive.southernMost = _sw.lat();
			this.largestAreaActive.easternMost = _ne.lng();
			this.largestAreaActive.westernMost = _sw.lng();
		},
		getBoundCoordinates: function () {
			return this.map.getBounds();
		},
		getAPIListCitiesInBound: function () {
			var _objMap = this, _cityAPI;
			callAjax(baseUrl + 'weather/getListCitiesInMapBound', 'GET', _objMap.largestAreaActive, true, function (json) {
				console.info('Call ajax successfully.');
				json = JSON.parse(json);
				for (i=0, c=json.length; i<c; i++) {
					_cityAPI = json[i].CityIDService;
					if (!_objMap.didCityGetData(_cityAPI) && _cityAPI.Weather !== null) {
						_objMap.createPopupCityWeather(json[i]);
					}
				}
			});	
		}
	};

	function CurrentLocation() {
		this.isFound = false;
		this.error = {};
	}
	CurrentLocation.prototype = {
		getCurrentLocation: function (map, initMap) {
			var _objLocation = this;
			navigator.geolocation.getCurrentPosition(function (data) {
				_objLocation.isFound = true;
				map.options.lat = data.coords.latitude;
				map.options.lng = data.coords.longitude;	
				initMap();
				map.drawMarker(map.options.lat, map.options.lng);
			}, function () {
				initMap();
			});
		}
	}

	var map = new Map();
	var cLocation = new CurrentLocation();
	var countryCode = new CountryCode();

	function initialize () {
		map.init();	
		
		google.maps.event.addListener(map.map, 'dragend', function() {
			map.updateMapBound(map.getBoundCoordinates());
			map.getAPIListCitiesInBound();
		});

		google.maps.event.addListener(map.map, 'zoom_changed', function() {
			map.updateMapBound(map.getBoundCoordinates());
			map.getAPIListCitiesInBound();
		});
	}

	google.maps.event.addDomListener(window, 'load', function () {
		cLocation.getCurrentLocation(map, initialize);
	});
</script>