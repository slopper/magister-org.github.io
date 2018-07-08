function send_post(url, name, data = '') {
	var form = '';
	
	if (data) {
		$.each(data.split('.'), function(k, v) {
			form += '&' + v + '=' + $('#' + v).val();
		});
	}

	$.ajax({
		type: 'POST',
		url: '/' + url,
		data: name + '_f=1' + form,
		cache: false,
		success: function(result) {
			
			obj = jQuery.parseJSON(result);

			if (obj.go)
				go(obj.go);
			else
				alert(obj.message);
		}
	});	
}


function go(url) {
	window.location.href = '/' + url;
}