jQuery(document).ready(function($){
	var sheet = window.document.styleSheets[0];

	var begin_enabled = false;

	if(night_mode.auto_set == true) {
		var start_hour = parseInt(night_mode.start_time.substring(0,2));
		var start_minute = parseInt(night_mode.start_time.substring(3,5));
		var end_hour = parseInt(night_mode.end_time.substring(0,2));
		var end_minute = parseInt(night_mode.end_time.substring(3,5));
		var d = new Date();
		var current_hour = parseInt(d.getHours());
		var current_minute = parseInt(d.getMinutes());
		if( start_hour == end_hour ) {
			begin_enabled = (current_hour == start_hour && start_minute < current_minute && end_minute > current_minute);
		} else if (start_hour < end_hour) {
			begin_enabled = ((start_hour == current_hour && start_minute <= current_minute) || (end_hour == current_hour && end_minute >= current_minute) || (start_hour < current_hour && end_hour > current_hour));
		} else {
			begin_enabled = ((start_hour == current_hour && start_minute <= current_minute) || (end_hour == current_hour && end_minute >= current_minute) || (start_hour < current_hour || end_hour > current_hour));
		}
	}

	var cookie_val = wpCookies.get('night-mode-enabled', '/');
	if( null != cookie_val && 'enabled' == cookie_val ) {
		begin_enabled = true;
	} else if( null != cookie_val && 'disabled' == cookie_val ) {
		begin_enabled = false;
	}

	if(begin_enabled == true) {
			sheet.insertRule("html, video, img {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);}", sheet.cssRules.length);
			$('#night_mode_checkbox').prop('checked', true);
			wpCookies.set('night-mode-enabled', 'enabled', 60, '/' );
	} else {
		wpCookies.set('night-mode-enabled', 'disabled', 60, '/' );
	}

	$( '#night_mode_checkbox' ).change(function(){
		console.log('changed');
		if(document.getElementById('night_mode_checkbox').checked){
			sheet.insertRule('html, video, img {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);}', sheet.cssRules.length);
			wpCookies.set('night-mode-enabled', 'enabled', 60, '/' );
		}
		else{
			sheet.insertRule('html, video, img{-webkit-filter: invert(0) hue-rotate(0deg);filter: invert(0) hue-rotate(0deg);}', sheet.cssRules.length);
			wpCookies.set('night-mode-enabled', 'disabled', 60, '/' );
		}
	});
});
