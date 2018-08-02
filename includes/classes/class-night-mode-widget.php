<?php
/**
 * Registers the Night Mode slider.
 */
class Night_Mode_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	public function __construct() {
		parent::__construct(
			'night_mode_switch',
			'Night-Mode Switch',
			array( 'description' => 'Adds a night-mode switch' )
		);
	}

	/**
	 * Code that runs on the frontend.
	 *
	 * @param  array $args     arguements.
	 * @param  array $instance parameters set in settings page.
	 */
	public function widget( $args, $instance ) {
		$data = array(
			'auto_set'   => false,
			'start_time' => '20:00',
			'end_time'   => '06:00',
		);
		if ( isset( $instance['nm_auto_set'] ) ) {
			$data['auto_set'] = $instance['nm_auto_set'];
		}
		if ( isset( $instance['nm_start_time'] ) ) {
			$data['start_time'] = $instance['nm_start_time'];
		}
		if ( isset( $instance['nm_end_time'] ) ) {
			$data['end_time'] = $instance['nm_end_time'];
		}

		wp_register_script( 'night-mode-frontend', plugins_url( 'includes/js/night-mode-frontend.js', NIGHT_MODE_BASENAME ), array( 'jquery' ) );

		wp_localize_script( 'night-mode-frontend', 'night_mode', $data );

		wp_enqueue_script( 'night-mode-frontend' );
	?>
		<div style="width:200px; height:100px;">
		<table class="borderless"><tr class="borderless"><th class="borderless">Night Mode</th>
		<td class="borderless">

					<label class="switch" id="night_mode">
					<input type="checkbox" id="night_mode_checkbox">
					<div class="slider round"></div></label>
		</td>
		</table></div></tr>
		<?php
	}

	/**
	 * Display settings for widget
	 *
	 * @param  array $instance previously saved settings.
	 */
	public function form( $instance ) {
		if ( isset( $instance['nm_auto_set'] ) ) {
			$nm_auto_set = $instance['nm_auto_set'];
		} else {
			$nm_auto_set             = false;
			$instance['nm_auto_set'] = false;
		}
		if ( isset( $instance['nm_start_time'] ) ) {
			$nm_start_time = $instance['nm_start_time'];
		} else {
			$nm_start_time             = '20:00';
			$instance['nm_start_time'] = '20:00';
		}
		if ( isset( $instance['nm_end_time'] ) ) {
			$nm_end_time = $instance['nm_end_time'];
		} else {
			$nm_end_time             = '06:00';
			$instance['nm_end_time'] = '06:00';
		}

		wp_register_script( 'night-mode-edit-widget', plugins_url( 'includes/js/night-mode-edit-widget.js', NIGHT_MODE_BASENAME ), array( 'jquery' ) );

		$data = array(
			'auto_set_field_id'   => $this->get_field_id( 'nm_auto_set' ),
			'start_time_field_id' => $this->get_field_id( 'nm_start_time' ),
			'end_time_field_id'   => $this->get_field_id( 'nm_end_time' ),
		);

		wp_localize_script( 'night-mode-edit-widget', 'night_mode', $data );

		wp_enqueue_script( 'night-mode-edit-widget' );

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

		<?php
	}

	/**
	 * Runs on save of widget
	 *
	 * @param  array $new_instance Settings that were just saved.
	 * @param  array $old_instance Settings that were previously saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['nm_auto_set']   = isset( $new_instance['nm_auto_set'] ) ? (bool) $new_instance['nm_auto_set'] : false;
		$instance['nm_start_time'] = isset( $new_instance['nm_start_time'] ) ? (string) $new_instance['nm_start_time'] : '20:00';
		$instance['nm_end_time']   = isset( $new_instance['nm_end_time'] ) ? (string) $new_instance['nm_end_time'] : '06:00';
		return $instance;
	}
}
?>
