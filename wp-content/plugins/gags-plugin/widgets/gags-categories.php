<?php
/**
* Gags categories widgets
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/
 
// Widgets
add_action( 'widgets_init', 'gags_categories_widget' );

// Register our widget
function gags_categories_widget() {
	register_widget( 'Gags_Categories' );
}

// Warrior Latest Video Widget
class Gags_Categories extends WP_Widget {

	//  Setting up the widget
	function Gags_Categories() {
		$widget_ops  = array( 'classname' => 'gag-categories-widget', 'description' => esc_html__( 'Display gag categories', 'gags-plugin' ) );
		$control_ops = array( 'id_base' => 'gags_categories' );

		parent::__construct( 'gags_categories', esc_html__( 'Gags - Categories', 'gags-plugin' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$gags_categories_title = apply_filters( 'widget_title', empty( $instance['gags_categories_title'] ) ? esc_html__( 'Gag Categories', 'gags-plugin' ) : $instance['gags_categories_title'], $instance, $this->id_base );

		echo $before_widget; ?>
		<?php echo $before_title . esc_attr( $gags_categories_title ) . $after_title; ?>
		<?php 
		$taxonomies = array( 
			'gag_category',
		);

		$args = array(
		'orderby'           => 'name', 
		'order'             => 'ASC',
		'hide_empty'        => false, 
		'fields'            => 'all',
		'parent'            => 0,
		'hierarchical'      => true,
		'child_of'          => 0,
		'pad_counts'        => false,
		'cache_domain'      => 'core'    
		);

		$terms = get_terms($taxonomies, $args);

		echo '<div class="categories">';
			echo '<ul>'; 

			foreach ( $terms as $term ) {
				echo '<li>' . '<a href="' . esc_attr(get_term_link($term, $taxonomies)) . '" title="' . sprintf( esc_html__( "View all posts in %s", "gags-plugin" ), $term->name ) . '" ' . '>' . $term->name.'</a></li>';

			    $subterms = get_terms($taxonomies, array(
			      'parent'   => $term->term_id,
			      'hide_empty' => false
			    ));

			    if($subterms) {
				    echo '<ul class="children">';
				    foreach ( $subterms as $subterm ) {
				      echo '<li>' . '<a href="' . esc_attr(get_term_link($subterm, $taxonomies)) . '" title="' . sprintf( esc_html__( "View all posts in %s", "gags-plugin" ), $subterm->name ) . '" ' . '>' . $subterm->name.'</a></li>';
				    }            
				    echo '</ul>'; //end subterms ul
				}

			  echo '</li>'; //end terms li
			} //end foreach term

			echo '</ul>';
		echo '</div>';
		?>
		<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['gags_categories_title'] = strip_tags( $new_instance['gags_categories_title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'gags_categories_title' => esc_html__( 'Gag Categories', 'gags-plugin' ) ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_categories_title' ); ?>"><?php esc_html_e('Widget Title:', 'gags-plugin'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_categories_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_categories_title' ); ?>" value="<?php echo esc_attr( $instance['gags_categories_title'] ); ?>" />
        </p>
	<?php
	}
}
?>