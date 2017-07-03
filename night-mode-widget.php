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
		if(isset($instance['checked'])){
			$checked = $instance['checked'];
		}
		else{
			$checked = false;
		}
		?>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $checked ); ?> id="<?php echo $this->get_field_id('checked'); ?>" name="<?php echo $this->get_field_name('checked') ?>">
			<label for="<?php echo $this->get_field_id('checked'); ?>">
				<?php _e('Checked'); ?>
			</label>
		</p>
		<?php
	}
	
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['checked'] = isset( $new_instance['checked'] ) ? (bool) $new_instance['checked'] : false;
		return $instance;
	}
}
add_action('widgets_init', function(){
	register_widget('Night_Mode');});


?>