jQuery(document).ready(function($){
	if(document.getElementById(night_mode.auto_set_field_id).checked == false){
		$('#'+night_mode.start_time_field_id).hide();
		$('#'+night_mode.end_time_field_id).hide();
		$('#'+night_mode.start_time_field_id+'_l').hide();
		$('#'+night_mode.end_time_field_id+'_l').hide();
	}

	$('#'+night_mode.auto_set_field_id).click(function(){
		if(document.getElementById(night_mode.auto_set_field_id).checked){
			$('#'+night_mode.start_time_field_id).show();
			$('#'+night_mode.end_time_field_id).show();
			$('#'+night_mode.start_time_field_id+'_l').show();
			$('#'+night_mode.end_time_field_id+'_l').show();
		}
		else{
			$('#'+night_mode.start_time_field_id).hide();
			$('#'+night_mode.end_time_field_id).hide();
			$('#'+night_mode.start_time_field_id+'_l').hide();
			$('#'+night_mode.end_time_field_id+'_l').hide();
		}
	});
});
