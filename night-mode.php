<?php
/*
Plugin Name: Night Mode
Description: Makes webpage night-friendly
Version: 0.0
Author: David Parker
*/
include plugin_dir_path( __FILE__ ) . 'night-mode-widget.php';
//Adds menu to settings
function nm_settings_page(){
	$nm_auto_place = get_option("nm_auto_place", NULL);
	if(is_null($nm_auto_place)){
		update_option("nm_auto_place", true);
		$nm_auto_place = true;
	}
	
	$nm_affect_pictures = get_option("nm_affect_pictures", NULL);
	if(is_null($nm_affect_pictures)){
		update_option("nm_affect_pictures", true);
		$nm_affect_pictures = true;
	}
	
	$nm_auto_set = get_option("nm_auto_set", NULL);
	if(is_null($nm_auto_set)){
		update_option("nm_auto_set", false);
		$nm_auto_set = false;
	}
	
	$nm_set_manually = get_option("nm_set_manually", NULL);
	if(is_null($nm_set_manually)){
		update_option("nm_set_manually", false);
		$nm_set_manually = false;
	}
	
	$nm_start_time = get_option("nm_start_time", NULL);
	if(is_null($nm_start_time)){
		update_option("nm_start_time", "20:00");
		$nm_start_time = "20:00";
	}
	$nm_end_time = get_option("nm_end_time", NULL);
	if(is_null($nm_end_time)){
		update_option("nm_end_time", "06:00");
		$nm_end_time = "06:00";
	}
	$nm_invert_color = get_option("nm_invert_color", NULL);
	if(is_null($nm_invert_color)){
		update_option("nm_invert_color", true);
		$nm_invert_color = true;
	}
	
	$nm_grey = get_option("nm_grey", NULL);
	if(is_null($nm_grey)){
		update_option("nm_grey", false);
		$nm_grey = false;
	}
	
	$nm_sepia = get_option("nm_sepia", NULL);
	if(is_null($nm_sepia)){
		update_option("nm_sepia", false);
		$nm_sepia = false;
	}

	
	?>
	<h1>Night Mode Settings</h1>
	<div style="background-color:white; width:400px;";>
		<h2>General Settings</h2>
		<table>
			<tr>
				<td>Automatically Place Switches</td>
				<td><input type="checkbox" id="nm_auto_place" <?php if($nm_auto_place == true){ echo "checked";} ?>>
				</td>
			</tr>
			<tr>
				<td>Affect Pictures</td>
				<td><input type="checkbox" id="nm_change_pics" <?php if($nm_affect_pictures == true){ echo "checked";} ?>></td>
			</tr>
			<tr>
				<td>Enable Night Mode Automatically</td>
				<td><input type="checkbox" id="nm_auto_set" <?php if($nm_auto_set == true){ echo "checked";} ?>></td>
			</tr>
			<tr id="nm_set_manually_tr">
				<td style="padding-left:3em">Set Times Manually</td>
				<td><input type="checkbox" id="nm_set_manually" <?php if($nm_set_manually == true){ echo "checked";} ?>></td>
			</tr>
			<tr id="nm_start_time_tr">
				<td style="padding-left:6em">Start Time</td>
				<td><input type="time" id="nm_start_time" value=<?php echo($nm_start_time)?>></td>
			</tr>
			<tr id="nm_end_time_tr">
				<td style="padding-left:6em">End Time</td>
				<td><input type="time" id="nm_end_time" value="<?php echo($nm_end_time)?>"></td>
			</tr>
		</table>
	</div>
	<div style="background-color:white; width:400px;";>
		<h2>Color Settings</h2>
		<table>
		<tr>
			<td>Color Inversion</td>
			<td><input type="checkbox" id="nm_invert_color" <?php if($nm_invert_color == true){ echo "checked";} ?>></td>
		</tr>
		<tr>
			<td>Greyscale</td>
			<td><input type="checkbox" id="nm_grey" <?php if($nm_grey == true){ echo "checked";} ?>></td>
		</tr>
		<tr>
			<td>Sepia</td>
			<td><input type="checkbox" id="nm_sepia" <?php if($nm_sepia == true){ echo "checked";} ?>></td>
		</tr>
		</table>
	</div>
	<input type="submit" value="Save" id="nm_save">
	
	<script type='text/javascript src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
	<script>
	jQuery(document).ready(function($){
		if(document.getElementById('nm_auto_set').checked == false){
			$('#nm_set_manually_tr').hide();
			$('#nm_start_time_tr').hide();
			$('#nm_end_time_tr').hide();
		}
		if(document.getElementById('nm_set_manually').checked == false){
			$('#nm_start_time_tr').hide();
			$('#nm_end_time_tr').hide();
		}
	
		$('#nm_auto_set').click(function(){
			if(document.getElementById('nm_auto_set').checked){
				$('#nm_set_manually_tr').show();
				if(document.getElementById('nm_set_manually').checked){
					$('#nm_start_time_tr').show();
					$('#nm_end_time_tr').show();
				}
			}
			else{
				$('#nm_set_manually_tr').hide();
				$('#nm_start_time_tr').hide();
				$('#nm_end_time_tr').hide();
			}
		});
		
		$('#nm_set_manually').click(function(){
			if(document.getElementById('nm_set_manually').checked){
				$('#nm_start_time_tr').show();
				$('#nm_end_time_tr').show();
			}
			else{
				$('#nm_start_time_tr').hide();
				$('#nm_end_time_tr').hide();
			}
		});
		
		$('#nm_save').click(function(){
		/*
			update_option("nm_auto_place", document.getElementById('nm_auto_place').checked);
			update_option("nm_affect_pictures", document.getElementById('nm_affect_pictures').checked);
			update_option("nm_auto_set", document.getElementById('nm_auto_set').checked);
			update_option("nm_set_manually", document.getElementById('nm_set_manually').checked);
			update_option("nm_start_time", document.getElementById('nm_start_time').value);
			update_option("nm_end_time", document.getElementById('nm_end_time').value);
			update_option("nm_invert_color", document.getElementById('nm_invert_color').checked);
			update_option("nm_grey", document.getElementById('nm_grey').checked);
			update_option("nm_sepia", document.getElementById('nm_sepia').checked);
		*/
		});
	});
	</script>
	<?php
}


function nm_init_settings_page() {
	//add license settings page
	add_options_page("Night Mode", "Night Mode", "manage_options", "night-mode.php", "nm_settings_page");
}
add_action('admin_menu', 'nm_init_settings_page');
?>