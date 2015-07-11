var baseUrl = 'http://localhost:130/snooker/index.php?r=';

function showSystemMessage (interval, message, _class) {
	if (showSystemMessage.called == true) {
		clearInterval(showSystemMessage.interval);
		clearTimeout(showSystemMessage.timeout);
		showSystemMessage.called = false;
	}
	showSystemMessage.called = true;
	var FDS = 60;
	var obj = $('#alert-site');
	var opacity = 1.0;
	var speedReduce = 1/(7000/FDS);
	obj.css('opacity', opacity);
	obj.removeClass().addClass(_class);
	obj.find('.alert-content').html(message);
	showSystemMessage.timeout = setTimeout(function () {
		showSystemMessage.interval = setInterval(function () {
			obj.css('opacity', opacity);
			opacity -= speedReduce;
			if (opacity < 0) {
				obj.css('opacity', 1).removeClass().addClass('hide');
				clearInterval(showSystemMessage.interval);
				clearTimeout(showSystemMessage.timeout);
				showSystemMessage.called = false;
			}
		}, (1000/FDS));
	}, 2000);
}

function showSystemMessageByObject (obj, interval, message, _class) {
	if (showSystemMessage.called == true) {
		clearInterval(showSystemMessage.interval);
		clearTimeout(showSystemMessage.timeout);
		showSystemMessage.called = false;
	}
	showSystemMessage.called = true;
	var FDS = 60;
	var opacity = 1.0;
	var speedReduce = 1/(7000/FDS);
	obj.css('opacity', opacity);
	obj.removeClass().addClass(_class);
	obj.find('.alert-content').html(message);
	showSystemMessage.timeout = setTimeout(function () {
		showSystemMessage.interval = setInterval(function () {
			obj.css('opacity', opacity);
			opacity -= speedReduce;
			if (opacity < 0) {
				obj.css('opacity', 1).removeClass().addClass('hide');
				clearInterval(showSystemMessage.interval);
				clearTimeout(showSystemMessage.timeout);
				showSystemMessage.called = false;
			}
		}, (1000/FDS));
	}, 2000);
}

function callAjax (url, type, data, async, callback) {
	$.ajax({
		url: url,
		type: type,
		data: data,
		async: async,
		success: function (kq) {
			callback(kq);
		}
	});
}