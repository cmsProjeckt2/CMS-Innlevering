<?php
/**
 * Widgets custom list category
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
 
// Widgets
add_action( 'widgets_init', 'gags_post_category_widget' );

// Register our widget
function gags_post_category_widget() {
	register_widget( 'Gags_Post_Category_List' );
}

// Gags Post Category List Widget
class Gags_Post_Category_List extends WP_Widget {

	//  Setting up the widget
	function Gags_Post_Category_List() {
		$widget_ops  = array( 'classname' => 'categories-widget', 'description' => esc_html__( 'Display custom post category list', 'gags' ) );
		$control_ops = array( 'id_base' => 'gags_post_category_list' );

		parent::__construct( 'gags_post_category_list', esc_html__( 'Custom Post Category List', 'gags' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $gags_option;
		
		extract( $args );

		$gags_post_category_list_title = apply_filters( 'widget_title', empty( $instance['gags_post_category_list_title'] ) ? esc_html__( 'Category List', 'gags' ) : $instance['gags_post_category_list_title'], $instance, $this->id_base );

		echo $before_widget; ?>
		<?php echo $before_title . esc_attr( $gags_post_category_list_title ) . $after_title; ?>
		<?php 
		$taxonomies = array( 
			'category',
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
				echo '<li>' . '<a href="' . esc_url( get_term_link($term, $taxonomies)) . '" title="' . sprintf( esc_html__( "View all posts in %s", "gags" ), $term->name ) . '" ' . '>' . $term->name.'</a></li>';

			    $subterms = get_terms($taxonomies, array(
			      'parent'   => $term->term_id,
			      'hide_empty' => false
			    ));

			    if($subterms) {
				    echo '<ul class="children">';
				    foreach ( $subterms as $subterm ) {
				      echo '<li>' . '<a href="' . esc_url( get_term_link($subterm, $taxonomies)) . '" title="' . sprintf( esc_html__( "View all posts in %s", "gags" ), $subterm->name ) . '" ' . '>' . $subterm->name.'</a></li>';
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

		$instance['gags_post_category_list_title'] = strip_tags( $new_instance['gags_post_category_list_title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'gags_post_category_list_title' => esc_html__( 'Category List', 'gags' ) ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_post_category_list_title' ); ?>"><?php esc_html_e('Widget Title:', 'gags'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_post_category_list_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_post_category_list_title' ); ?>" value="<?php echo esc_attr( $instance['gags_post_category_list_title'] ); ?>" />
        </p>
	<?php
	}
}
?>