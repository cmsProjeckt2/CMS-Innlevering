<?php
/**
* Gags custom menu widgets
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/
 
// Widgets
add_action( 'widgets_init', 'gags_custom_menu_widget' );

// Register our widget
function gags_custom_menu_widget() {
	register_widget( 'Gags_Custom_Menu' );
}

// Warrior Latest Video Widget
class Gags_Custom_Menu extends WP_Widget {

	//  Setting up the widget
	function Gags_Custom_Menu() {
		$widget_ops  = array( 'classname' => 'gag-custom-menu-widget', 'description' => esc_html__( 'Display gag custom menu', 'gags' ) );
		$control_ops = array( 'id_base' => 'gags_custom_menu' );

		parent::__construct( 'gags_custom_menu', esc_html__( 'Gags - Custom Menu', 'gags' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$gags_custom_menu_title = apply_filters( 'widget_title', empty( $instance['gags_custom_menu_title'] ) ? esc_html__( 'Gags Menu', 'gags' ) : $instance['gags_custom_menu_title'], $instance, $this->id_base );
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		echo $before_widget; ?>
		<?php echo $before_title . esc_attr( $gags_custom_menu_title ) . $after_title; ?>
			<?php  wp_nav_menu( array( 'menu' => $nav_menu) ); ?>
		<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['gags_custom_menu_title'] = strip_tags( $new_instance['gags_custom_menu_title'] );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'gags_custom_menu_title' => esc_html__( 'Gags Menu', 'gags' ), 'nav_menu' => '' ) );
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		// Get menus
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

        // If no menus exists, direct the user to go and create some.
        if ( !$menus ) {
            echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.', 'gags'), admin_url('nav-menus.php') ) .'</p>';
            return;
        }
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_custom_menu_title' ); ?>"><?php esc_html_e('Widget Title:', 'gags'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_custom_menu_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_custom_menu_title' ); ?>" value="<?php echo esc_attr( $instance['gags_custom_menu_title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php esc_html_e('Select Menu : ', 'gags'); ?></label>
            <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
        <?php
            foreach ( $menus as $menu ) {
                $selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
                echo '<option'. $selected .' value="'. esc_attr( $menu->term_id ).'">'. $menu->name .'</option>';
            }
        ?>
            </select>
        </p>
	<?php
	}
}
?>