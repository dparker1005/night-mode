<?php
/*
Plugin Name: Night Mode
Description: A widget that makes webpages night-friendly
Version: 1.0
Author: David Parker
*/

class Night_Mode extends WP_Widget{
	public function __construct(){
		parent::__construct(
		'night_mode_switch',
			'Night-Mode Switch',
			array('description'=>'Adds a night-mode switch')
		);
	}
	
	public function widget($args, $instance){
		if(isset($instance['nm_auto_set'])){
			$nm_auto_set = $instance['nm_auto_set'];
			$instance['nm_auto_set'] = false;
		}
		else{
			$nm_auto_set = false;
		}
		//determine whether or not page should start in night-mode
		if($nm_auto_set==true){
			//make sure variables have values

			if(isset($instance['nm_start_time'])){
				$nm_start_time = $instance['nm_start_time'];
			}
			else{
				$nm_start_time = "20:00";
				$instance['nm_start_time'] = "20:00";
			}
			if(isset($instance['nm_end_time'])){
				$nm_end_time = $instance['nm_end_time'];
			}
			else{
				$nm_end_time = "06:00";
				$instance['nm_end_time'] = "06:00";
			}
		
			//get current time(of server)
			date_default_timezone_set("America/New_York");
			$current_hour = (int)date("H");
			$current_minute = (int)date("i");
		
			$start_time = explode(":", $nm_start_time);
			$start_hour = (int)$start_time[0];
			$start_minute = (int)$start_time[1];
		
			$end_time = explode(":", $nm_end_time);
			$end_hour = (int)$end_time[0];
			$end_minute = (int)$end_time[1];
		
			//compare times
			if($current_hour>$start_hour){$current_before_start=false;}
			else if($current_hour<$start_hour){$current_before_start=true;}
			else if($current_minute>$start_minute){$current_before_start=false;}
			else{$current_before_start=true;}
			
			if($current_hour>$end_hour){$current_before_end=false;}
			else if($current_hour<$end_hour){$current_before_end=true;}
			else if($current_minute>$end_minute){$current_before_end=false;}
			else{$current_before_end=true;}
		
			if($start_hour>$end_hour){$start_before_end=false;}
			else if($start_hour<$end_hour){$start_before_end=true;}
			else if($start_minute>$end_minute){$start_before_end=false;}
			else{$start_before_end=true;}
			
			//determine if night-mode should be active
			if(($start_before_end==true && $current_before_start==false && $current_before_end = true) 
				|| ($start_before_end == false && ($current_before_start == false || $current_before_end == true))){
				$auto_set = true;
			}
			else{
				$auto_set = false;
			}
			
		}
		else{
			$auto_set = false;
		}
	?>
		<div style="width:200px; height:100px;">
		<table class="borderless"><tr class="borderless"><th class="borderless">Night Mode</th>
		<td class="borderless">
		
					<label class="switch" id="nightmode">
					<input type="checkbox" id="nightmode_checkbox" <?php if($auto_set==true){echo("checked");}?>>
					<div class="slider round"></div></label>
		</td>
		</table></div></tr>
	
		<style>
			.borderless {
				border: 0px;
			}
		
		/* Copied from https://www.w3schools.com/howto/howto_css_switch.asp */
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
		//CSS filter found at https://lnikki.la/articles/night-mode-css-filter/	
		jQuery(document).ready(function($){
			var sheet = window.document.styleSheets[0];
			<?php 
				if($auto_set==true){
					//echo('sheet.insertRule("html, video, img {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);background: black;}", sheet.cssRules.length);');
					echo('sheet.insertRule("html, video, img {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);}", sheet.cssRules.length);');
				}
			?>
			$( '#nightmode' ).click(function(){
				if(document.getElementById('nightmode_checkbox').checked){
					//sheet.insertRule('html, video, img {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);background: black;}', sheet.cssRules.length);	
					sheet.insertRule('html, video, img {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);}', sheet.cssRules.length);	
				}
				else{
					//sheet.insertRule('html, video, img {-webkit-filter: invert(0) hue-rotate(0deg);filter: invert(0) hue-rotate(0deg);}', sheet.cssRules.length);
					sheet.insertRule('html, video, img{-webkit-filter: invert(0) hue-rotate(0deg);filter: invert(0) hue-rotate(0deg);}', sheet.cssRules.length);
				}
			});
		});
		</script>
	<?php
	}

	public function form($instance){
		if(isset($instance['nm_auto_set'])){
			$nm_auto_set = $instance['nm_auto_set'];
		}
		else{
			$nm_auto_set = false;
			$instance['nm_auto_set'] = false;
		}
		if(isset($instance['nm_start_time'])){
			$nm_start_time = $instance['nm_start_time'];
		}
		else{
			$nm_start_time = "20:00";
			$instance['nm_start_time'] = "20:00";
		}
		if(isset($instance['nm_end_time'])){
			$nm_end_time = $instance['nm_end_time'];
		}
		else{
			$nm_end_time = "06:00";
			$instance['nm_end_time'] = "06:00";
		}
		?>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $nm_auto_set ); ?> id="<?php echo $this->get_field_id('nm_auto_set'); ?>" name="<?php echo $this->get_field_name('nm_auto_set') ?>">
			<label for="<?php echo $this->get_field_id('nm_auto_set'); ?>">
				<?php _e('Auto-Set Based On Time'); ?>
			</label>
		</p>
		<p class="nm_edit_time">
			<input type="time" id="<?php echo $this->get_field_id('nm_start_time'); ?>" name="<?php echo $this->get_field_name('nm_start_time') ?>" value=<?php echo($nm_start_time)?>>
			<label id="<?php echo $this->get_field_id('nm_start_time'); ?>_l" for="<?php echo $this->get_field_id('nm_start_time'); ?>">
				<?php _e('Start Time'); ?>
			</label>
		</p>
		<p class="nm_edit_time">
			<input type="time" id="<?php echo $this->get_field_id('nm_end_time'); ?>" name="<?php echo $this->get_field_name('nm_end_time') ?>" value=<?php echo($nm_end_time)?>>
			<label id="<?php echo $this->get_field_id('nm_end_time'); ?>_l" for="<?php echo $this->get_field_id('nm_end_time'); ?>">
				<?php _e('End Time'); ?>
			</label>
		</p>
		
		<script>
			jQuery(document).ready(function($){
				console.log("<?php echo $this->get_field_id('nm_auto_set'); ?>");
				if(document.getElementById("<?php echo $this->get_field_id('nm_auto_set'); ?>").checked == false){
					$('#<?php echo $this->get_field_id('nm_start_time'); ?>').hide();
					$('#<?php echo $this->get_field_id('nm_end_time'); ?>').hide();
					$('#<?php echo $this->get_field_id('nm_start_time'); ?>_l').hide();
					$('#<?php echo $this->get_field_id('nm_end_time'); ?>_l').hide();
				}
	
				$('#<?php echo $this->get_field_id('nm_auto_set'); ?>').click(function(){
					if(document.getElementById("<?php echo $this->get_field_id('nm_auto_set'); ?>").checked){
						$('#<?php echo $this->get_field_id('nm_start_time'); ?>').show();
						$('#<?php echo $this->get_field_id('nm_end_time'); ?>').show();
						$('#<?php echo $this->get_field_id('nm_start_time'); ?>_l').show();
						$('#<?php echo $this->get_field_id('nm_end_time'); ?>_l').show();
					}
					else{
						$('#<?php echo $this->get_field_id('nm_start_time'); ?>').hide();
						$('#<?php echo $this->get_field_id('nm_end_time'); ?>').hide();
						$('#<?php echo $this->get_field_id('nm_start_time'); ?>_l').hide();
						$('#<?php echo $this->get_field_id('nm_end_time'); ?>_l').hide();
					}
				});
			});
 		</script>
 		
		<?php
	}
	
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['nm_auto_set'] = isset( $new_instance['nm_auto_set'] ) ? (bool) $new_instance['nm_auto_set'] : false;
		$instance['nm_start_time'] = isset( $new_instance['nm_start_time'] ) ? (string) $new_instance['nm_start_time'] : "20:00";
		$instance['nm_end_time'] = isset( $new_instance['nm_end_time'] ) ? (string) $new_instance['nm_end_time'] : "06:00";
		return $instance;
	}
}
add_action('widgets_init', function(){
	register_widget('Night_Mode');});
?>