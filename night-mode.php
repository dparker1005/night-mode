<?php
/*
Plugin Name: Night Mode
Description: Makes webpage night-friendly
Version: 0.0
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
	?>
		<div style="width:200px; height:100px;">
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
  		$( '#nightmode' ).click(function(){
  		var sheet = window.document.styleSheets[0]

        if(document.getElementById('nightmode_checkbox').checked){
			sheet.insertRule('html, video {-webkit-filter: invert(1) hue-rotate(180deg);filter: invert(1) hue-rotate(180deg);background: black;}', sheet.cssRules.length);
			
        }
        else{
        	sheet.insertRule('html, video {-webkit-filter: invert(0) hue-rotate(0deg);filter: invert(0) hue-rotate(0deg);}', sheet.cssRules.length);
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
		}
		if(isset($instance['nm_start_time'])){
			$nm_start_time = $instance['nm_start_time'];
		}
		else{
			$nm_start_time = "20:00";
		}
		if(isset($instance['nm_end_time'])){
			$nm_end_time = $instance['nm_end_time'];
		}
		else{
			$nm_end_time = "06:00";
		}
		?>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $nm_auto_set ); ?> id="<?php echo $this->get_field_id('nm_auto_set'); ?>" name="<?php echo $this->get_field_name('nm_auto_set') ?>">
			<label for="<?php echo $this->get_field_id('nm_auto_set'); ?>">
				<?php _e('Auto-Set Based On Time'); ?>
			</label>
		</p>
		<p>
			<input type="time" id="<?php echo $this->get_field_id('nm_start_time'); ?>" name="<?php echo $this->get_field_name('nm_start_time') ?>" value=<?php echo($nm_start_time)?>>
			<label for="<?php echo $this->get_field_id('nm_start_time'); ?>">
				<?php _e('Start Time'); ?>
			</label>
		</p>
		<p>
			<input type="time" id="<?php echo $this->get_field_id('nm_end_time'); ?>" name="<?php echo $this->get_field_name('nm_end_time') ?>" value=<?php echo($nm_end_time)?>>
			<label for="<?php echo $this->get_field_id('nm_end_time'); ?>">
				<?php _e('End Time'); ?>
			</label>
		</p>
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