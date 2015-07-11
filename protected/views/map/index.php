<style type="text/css">
	#content-left, 
	#content-right {
		display: none;
	}
	#content-center {
		width: 100%;
		margin: auto;
	}
	#map-index {}
	#map-index .alert-info {
		color: #fff;
		background-color: #31708f;
		border-color: #bce8f1;
	}
	#map-index .row {
		margin: 6px 0 0;
		line-height: 20px;
	}
	#map-index .row:last-child {
		text-align: center;
	}
	#map-index .wrap_map_view {
		float: left;
		width: 31.33333333333%;
		margin-right: 1%;
		margin-left: 1%;
		margin-bottom: 12px;
		border: 1px solid #181;
		border-radius: 5px;
		position: relative;
	}
	#map-index .wrap_map_view .map_view {
		height: 350px;
		border-radius: 5px;
	}
	#map-index .wrap_map_view .title {
		float: left;
		width: 45%;
		margin-right: 5%;
		font-size: 12px;
		padding-left: 10px;
	}
	#map-index .wrap_map_view .value {
		float: left;
		width: 50%;
		font-size: 14px;
	}
	#map-index .wrap_map_view .info {
		padding-bottom: 10px;
	}
	#map-index .wrap_map_view .name_city {
		padding: 3px 10px;
		text-align: center;
		line-height: 32px;
	}
	#map-index .wrap_map_view .name_city .txt-city-name {
		line-height: 26px;
	}
	#map-index .wrap_map_view .alert {
		position: absolute;
		top: 30px;
		width: 300px;
		left: 50%;
		margin-left: -150px;
		z-index: 9999;
	}
</style>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<div id="map-index">
	
</div>
<script type="text/javascript">
	function Map (key) {
		this.options = {};
		this.map = {};
		this.key = key;
	}
	Map.prototype.init = function (lat, lng, zoom) {
		this.options = {
			center: {lat: lat, lng: lng},
			zoom: zoom
		};
	}
	Map.prototype.dragEnd = function () {
		var _mapObj = this, strCoordinates, arrCoordinates;
		google.maps.event.addListener(this.map, 'dragend', function () {
			_mapObj.updateHTMLByMapData(_mapObj);
		});
	}
	Map.prototype.zoomChange = function () {
		var _mapObj = this;
		google.maps.event.addListener(this.map, 'zoom_changed', function () {
			_mapObj.updateHTMLByMapData(_mapObj);
		});
	}
	Map.prototype.viewDataHTML = function (objHtml, value) {
		$('#map-'+this.key).parent().find(objHtml).html(value);
	}
	Map.prototype.updateHTMLByMapData = function (objMap) {
		var strCoordinates = objMap.map.getCenter().toString();
		var arrCoordinates = strCoordinates.split(/[\(\)\,\ ]/);
		var zoomLevel = objMap.map.getZoom();
		objMap.viewDataHTML('.map_info_lat', arrCoordinates[1]);
		objMap.viewDataHTML('.map_info_lng', arrCoordinates[3]);
		objMap.viewDataHTML('.map_info_zoom', zoomLevel);
		objMap.init(parseFloat(arrCoordinates[1]), parseFloat(arrCoordinates[3]), zoomLevel);
	}
	Map.prototype.updateCoordinates = function () {
		var _mapObj = this;
		callAjax(baseUrl + 'map/updateCoordinates', 'POST', {
			latitude: _mapObj.options.center.lat,
			longtitude: _mapObj.options.center.lng,
			zoom: _mapObj.options.zoom,
			id: _mapObj.key
		}, true, function (json) {
			json = JSON.parse(json);
			if (json.status == 'OK') {
				showSystemMessageByObject ($('#alert-map-'+_mapObj.key), '', 'Update Coordinates success', 'alert alert-info');
			}
		});
	}
	Map.prototype.insertNewMap = function (name_city) {
		var _mapObj = this;
		if (this.validate(name_city)) {
			callAjax(baseUrl + 'map/addMap', 'POST', {
				latitude: _mapObj.options.center.lat,
				longtitude: _mapObj.options.center.lng,
				zoom: _mapObj.options.zoom,
				name: name_city
			}, true, function (json) {

			});
		}
	}
	Map.prototype.validate = function (name_city) {
		var _mapObj = this;
		if (name_city == '') {
			showSystemMessageByObject ($('#alert-map-0'), '', 'Name of city is incorrect.', 'alert alert-danger');
			return false;
		}
		return true;
	}


	var map = [], cities;

	function initialize () {
		var _id, tmp;
		callAjax(baseUrl + 'map/getDataCities', 'GET', {}, true, function (json) {
			cities = JSON.parse(json);
			for (var i=0, c=cities.length; i<c; i++) {
				_id = cities[i]['id'];
				cities[i]['latitude'] = parseFloat(cities[i]['latitude']);
				cities[i]['longtitude'] = parseFloat(cities[i]['longtitude']);
				cities[i]['zoom'] = parseInt(cities[i]['zoom']);

				tmp = createObjectOfMap(_id, i, true, cities[i]['latitude'], cities[i]['longtitude'], cities[i]['zoom'], cities[i]['name']);
				map.push(tmp);
			}
			createObjectOfMap(0, -1, false, 0, 0, 0, undefined);
		});	
	}
	google.maps.event.addDomListener(window, 'load', initialize);

	function createObjectOfMap (map_key, numberth, isCreated, lat, lng, zoom, name_city) {
		var tmp;
		appendMapToHTML(map_key, numberth);
		tmp = new Map(map_key);
		tmp.init(lat, lng, zoom);
		tmp.map = new google.maps.Map(document.getElementById('map-'+(map_key)), tmp.options);
		tmp.zoomChange();
		tmp.dragEnd();
		tmp.viewDataHTML('.map_info_zoom', tmp.options.zoom);
		tmp.viewDataHTML('.map_info_lat', tmp.options.center.lat);
		tmp.viewDataHTML('.map_info_lng', tmp.options.center.lng);
		if (name_city !== undefined) {
			tmp.viewDataHTML('.name_city', name_city);
		} else {
			tmp.viewDataHTML('.name_city', '<input type="text" class="txt-city-name">');
			$('.btn-update-coordinates[numberth="'+numberth+'"]').val('Insert This Place').removeClass('btn-update-coordinates btn-primary').addClass('btn-add-coordinates btn-success');
		}
		return tmp;
	}

	function appendMapToHTML (map_key, numberth) {
		$('#map-index').append('<div class="wrap_map_view">' +
			'<div class="alert" id="alert-map-'+map_key+'"><div class="alert-content"></div></div>' +
			'<div class="name_city"></div>' +
			'<div class="map_view" id="map-'+map_key+'"></div>' +
			'<div class="info">' +
				'<div class="row">' +
					'<div class="title">Center Latitude</div>' +
					'<div class="value map_info_lat"></div>' +
					'<div class="clearfix"></div>' +
				'</div>' +
				'<div class="row">' +
					'<div class="title">Center Longtitude</div>' +
					'<div class="value map_info_lng"></div>' +
					'<div class="clearfix"></div>' +
				'</div>' +
				'<div class="row">' +
					'<div class="title">Zoom Level</div>' +
					'<div class="value map_info_zoom"></div>' +
					'<div class="clearfix"></div>' +
				'</div>' +
				'<div class="row">' +
					'<input type="button" class="btn btn-primary btn-update-coordinates" numberth="'+numberth+'" value="Update Coordinates">' +
				'</div>' +
			'</div>' +
		'</div>');
	}

	$(document).on('click', '.btn-update-coordinates', function () {
		var _numberth = $(this).attr('numberth');
		var tmp = map[_numberth];
		tmp.updateCoordinates();
	});

	$(document).on('click', '.btn-add-coordinates', function () {
		var _parentObjHTML = $(this).parent().parent().parent();
		var _newMap = new Map(-1);
		var _lat = _parentObjHTML.find('.map_info_lat').html();
		var _lng = _parentObjHTML.find('.map_info_lng').html();
		var _zoom = _parentObjHTML.find('.map_info_zoom').html();
		var _name = _parentObjHTML.find('.txt-city-name').val();
		_newMap.init(_lat, _lng, _zoom);
		_newMap.insertNewMap(_name);
	});

</script>