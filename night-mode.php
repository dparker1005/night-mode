<?php
/*
Plugin Name: Night Mode
Description: Makes webpage night-friendly
Version: 0.0
Author: David Parker
*/

global $switchAdded;
$switchAdded = false;

//Creates switch, adds JQuery to enable Night Mode
function nmAddSwitch(){
	global $switchAdded;
	if($switchAdded == true){
		return;
	}
	$switchAdded = true;

	require_once(ABSPATH . "wp-admin/includes/screen.php");
	$screen = get_current_screen();

	/*
	 * Check if current screen is My Admin Page
	 */
	if ( is_null($screen) ){
	?>
	<script>console.log("rip");</script>
	<div style="width:30px;">
	<table><tr><th>Night Mode</th>
	<td>
		
				<label class="switch" id="nightmode">
				<input type="checkbox" id="nightmode_checkbox">
				<div class="slider round"></div></label>
	</td>
	</table></div></tr>
	
	<style>
	/* The switch - the box around the slider */
		#nightmode {
		  position: relative;
		  display: inline-block;
		  width: 60px;
		  height: 34px;
		}

		/* Hide default HTML checkbox */
		#nightmode input {display:none;}

		/* The slider */
		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #ccc;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		.slider:before {
		  position: absolute;
		  content: "";
		  height: 26px;
		  width: 26px;
		  left: 4px;
		  bottom: 4px;
		  background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #f37e21;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}
	</style>
	<script type='text/javascript src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
	<script>
	jQuery(document).ready(function($){
  		//you can now use $ as your jQuery object.
  		var nightmode = $( '#nightmode' );
  		nightmode.click(function(){
  		var sheet = window.document.styleSheets[0]

        if(document.getElementById('nightmode_checkbox').checked)
        {
        	console.log("Checked");
        	//If you add image, it won't be affected
			sheet.insertRule('html, video {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);background: black;}', sheet.cssRules.length);
			
        }
        else
        {
        	console.log("Unchecked");
        	sheet.insertRule('html, video {-webkit-filter: invert(0) hue-rotate(0deg);filter: invert(0) hue-rotate(0deg);}', sheet.cssRules.length);
        }
	});
	});
	</script>
<?php
}
}
add_action('the_post', 'nmAddSwitch');


//Adds menu to settings
function nm_settings_page(){
	echo "got it";
}


function nm_init_settings_page() {
	//add license settings page
	add_options_page("Night Mode", "Night Mode", "manage_options", "night-mode.php", "nm_settings_page");
}
add_action('admin_menu', 'nm_init_settings_page');
?>