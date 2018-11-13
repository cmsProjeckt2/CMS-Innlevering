<?php
/**
* Recent gags widgets
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/
 
// Widgets
add_action( 'widgets_init', 'gags_recent_posts_widget' );

// Register our widget
function gags_recent_posts_widget() {
	register_widget( 'Gags_Recent_Posts' );
}

// Gags Recent Posts Widget
class Gags_Recent_Posts extends WP_Widget {

	//  Setting up the widget
	function Gags_Recent_Posts() {
		$widget_ops  = array( 'classname' => 'recent-widget recent-post-widget', 'description' => esc_html__( 'Display recent gags.', 'gags-plugin' ) );
		$control_ops = array( 'id_base' => 'gags_recent_posts' );

		parent::__construct( 'gags_recent_posts', esc_html__( 'Gags - Recent Gags', 'gags-plugin' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$gags_recent_posts_title = apply_filters( 'widget_title', empty( $instance['gags_recent_posts_title'] ) ?  esc_html__( 'Recent Gags', 'gags-plugin' ) : $instance['gags_recent_posts_title'], $instance, $this->id_base );
		$gags_recent_posts_count = !empty( $instance['gags_recent_posts_count'] ) ? absint( $instance['gags_recent_posts_count'] ) : 4;
		$gags_recent_title_limiter = !empty( $instance['gags_recent_title_limiter'] ) ? absint( $instance['gags_recent_title_limiter'] ) : 10;

		$args = array(
			'post_type' 			=> 'gag',
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> 1,
			'posts_per_page' 		=> absint( $gags_recent_posts_count )
		);

		$wp_query = new WP_Query();
		$wp_query->query( $args );

			echo $before_widget; ?>

				<?php echo $before_title . esc_attr( $gags_recent_posts_title ) . $after_title; ?>
				<div class="recents-widget popular-posts">
					<?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<article class="hentry post">
							<div class="thumbnail">
							<?php
								$gags_get_nfsw = get_post_meta( get_the_ID(), '_gag_nfsw', true );
								if($gags_get_nfsw == 'on') :
									$thumb_image = "http://placehold.it/300x140/?text=".esc_html__('NSFW', 'gags-plugin');
									echo '<div class="thumbnail">';
										echo '<a href="'.esc_url( get_permalink() ).'" title="'.get_the_title().'" alt="'.get_the_title().'">';
											echo '<img src="'. esc_url( $thumb_image ).'" alt="'.get_the_title().'" title="'.get_the_title().'">';
										echo '</a>';
									echo '</div>';
							?>
							<?php elseif ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'gags-popular-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) ); ?>
								</a>
							<?php else : ?>
								<?php $thumb_image = "http://placehold.it/301x140/?text=".esc_html__('No Thumbnail', 'gags-plugin'); ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
									<img src="<?php echo esc_url( $thumb_image ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
								</a>
							<?php endif; ?>
							</div>
							<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), absint( $gags_recent_title_limiter ), '...' ); ?></a></h3>
						</article>
					<?php endwhile; else : esc_html_e( 'No recent gags found.', 'gags-plugin' ); endif; ?>
				</div>

			<?php wp_reset_postdata(); ?>
			<?php echo $after_widget; 

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['gags_recent_posts_title'] 	= strip_tags( $new_instance['gags_recent_posts_title'] );
		$instance['gags_recent_posts_count']  	= (int) $new_instance['gags_recent_posts_count'];
		$instance['gags_recent_title_limiter']  = (int) $new_instance['gags_recent_title_limiter'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'gags_recent_posts_title' => esc_html__( 'Recent Gags', 'gags-plugin' ), 'gags_recent_posts_count' => '5', 'gags_recent_title_limiter' => '10' ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_recent_posts_title' ); ?>"><?php esc_html_e( 'Widget Title:', 'gags-plugin' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_recent_posts_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_recent_posts_title' ); ?>" value="<?php echo esc_attr( $instance['gags_recent_posts_title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_recent_posts_count' ); ?>"><?php esc_html_e( 'Number of posts to show:', 'gags-plugin' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_recent_posts_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_recent_posts_count' ); ?>" value="<?php echo absint( $instance['gags_recent_posts_count'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_recent_title_limiter' ); ?>"><?php esc_html_e( 'Post Title Limiter', 'gags-plugin' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_recent_title_limiter' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_recent_title_limiter' ); ?>" value="<?php echo absint( $instance['gags_recent_title_limiter'] ); ?>" />
            <p><small><?php esc_html_e( 'The post title will be trim after reaching the number of characters defined.', 'gags-plugin' ); ?></small></p>
        </p>
	<?php
	}
}
?>