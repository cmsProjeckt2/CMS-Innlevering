<?php
/**
* Trending gags widgets
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/
 
// Widgets
add_action( 'widgets_init', 'gags_trending_posts_widget' );

// Register our widget
function gags_trending_posts_widget() {
	register_widget( 'Gags_Trending_Posts' );
}

// Gags Trending Topic Widget
class Gags_Trending_Posts extends WP_Widget {

	//  Setting up the widget
	function Gags_Trending_Posts() {
		$widget_ops  = array( 'classname' => 'recent-widget gags_trending_posts', 'description' => esc_html__( 'Display trending gags.', 'gags-plugin' ) );
		$control_ops = array( 'id_base' => 'gags_trending_posts' );

		parent::__construct( 'gags_trending_posts', esc_html__( 'Gags - Trending Gags', 'gags-plugin' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$gags_trending_gags_title = apply_filters('widget_title', empty( $instance['gags_trending_gags_title'] ) ? esc_html__( 'Trending Gags', 'gags-plugin' ) : $instance['gags_trending_gags_title'], $instance, $this->id_base );
		$gags_trending_gags_count = !empty( $instance['gags_trending_gags_count'] ) ? absint( $instance['gags_trending_gags_count'] ) : 5;
		$gags_trending_gags_title_limiter = !empty( $instance['gags_trending_gags_title_limiter'] ) ? absint( $instance['gags_trending_gags_title_limiter'] ) : 10;
		$gags_range_time = esc_attr($instance['gags_range_time'] );

			// Get the posts from database
			$args = array(
				'orderby'               => 'comment_count, meta_value_num',
		        'meta_query' => array(
		            array(
		                'key'  => '_post_like_count'
		            ),
		        ),
		        'order'                 => 'desc',
		        'post_type'             => 'gag',
		        'post_status'           => 'publish',
		        'date_query'            => array(
		             array(
		                'column'    => 'post_date',
		                'after'     => esc_attr( $gags_range_time )
		             ),
		         ),
		        'ignore_sticky_posts'   => 1,
				'posts_per_page' => absint( $gags_trending_gags_count )
			);

			$wp_query = new WP_Query();
			$wp_query->query( $args );

			echo $before_widget; ?>
				<?php echo $before_title . esc_attr( $gags_trending_gags_title ) . $after_title; ?>
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
							<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), absint( $gags_trending_gags_title_limiter ), '...' ); ?></a></h3>
						</article>
					<?php endwhile; else : esc_html_e( 'No trending gags found.', 'gags-plugin' ); endif; ?>
				</div>

			<?php wp_reset_postdata(); ?>	
			<?php echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['gags_trending_gags_title'] 	= strip_tags( $new_instance['gags_trending_gags_title'] );
		$instance['gags_trending_gags_count']  	= (int) $new_instance['gags_trending_gags_count'];
		$instance['gags_trending_gags_title_limiter']  = (int) $new_instance['gags_trending_gags_title_limiter'];
		$instance['gags_range_time']		= esc_attr( $new_instance['gags_range_time'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'gags_trending_gags_title' => esc_html__( 'Trending Gags', 'gags-plugin' ), 'gags_trending_gags_count' => '5', 'gags_trending_gags_title_limiter' => '10','gags_range_time' => '2 days ago') );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_trending_gags_title' ); ?>"><?php esc_html_e( 'Widget Title:', 'gags-plugin' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_trending_gags_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_trending_gags_title' ); ?>" value="<?php echo esc_attr( $instance['gags_trending_gags_title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_trending_gags_count' ); ?>"><?php esc_html_e('Number of posts to show:', 'gags-plugin'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_trending_gags_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_trending_gags_count' ); ?>" value="<?php echo absint( $instance['gags_trending_gags_count'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_trending_gags_title_limiter' ); ?>"><?php esc_html_e('Post Title Limiter', 'gags-plugin'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_trending_gags_title_limiter' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_trending_gags_title_limiter' ); ?>" value="<?php echo absint( $instance['gags_trending_gags_title_limiter'] ); ?>" />
            <p><small><?php esc_html_e( 'The post title will be trim after reaching the number of characters defined.', 'gags-plugin' ); ?></small></p>
        </p>
        <p>
         <label for="<?php echo $this->get_field_id( 'gags_range_time' ); ?>"><?php esc_html_e('Post Date Range:', 'gags-plugin'); ?></label>
            <?php $layout = $instance['gags_range_time']; ?>
            <select class='widefat' id="<?php echo $this->get_field_id('gags_range_time'); ?>" name="<?php echo $this->get_field_name('gags_range_time'); ?>" type="text">
			    <option value='1 day ago'<?php echo ($layout =='1 day ago')?'selected':''; ?>> <?php esc_html_e('1 day ago', 'gags-plugin'); ?> </option>
			    <option value='2 days ago'<?php echo ($layout =='2 days ago')?'selected':''; ?>> <?php esc_html_e('2 days ago', 'gags-plugin'); ?> </option> 
			    <option value='3 days ago'<?php echo ($layout =='3 days ago')?'selected':''; ?>> <?php esc_html_e('3 days ago', 'gags-plugin'); ?> </option> 
			    <option value='4 days ago'<?php echo ($layout =='4 days ago')?'selected':''; ?>> <?php esc_html_e('4 days ago', 'gags-plugin'); ?> </option> 
			    <option value='5 days ago'<?php echo ($layout =='5 days ago')?'selected':''; ?>> <?php esc_html_e('5 days ago', 'gags-plugin'); ?> </option> 
			    <option value='6 days ago'<?php echo ($layout =='6 days ago')?'selected':''; ?>> <?php esc_html_e('6 days ago', 'gags-plugin'); ?> </option> 
			    <option value='1 week ago'<?php echo ($layout =='1 week ago')?'selected':''; ?>> <?php esc_html_e('1 week ago', 'gags-plugin'); ?> </option> 
			    <option value='2 weeks ago'<?php echo ($layout =='2 weeks ago')?'selected':''; ?>> <?php esc_html_e('2 weeks ago', 'gags-plugin'); ?> </option> 
			    <option value='1 month ago'<?php echo ($layout =='1 month ago')?'selected':''; ?>> <?php esc_html_e('1 month ago', 'gags-plugin'); ?> </option> 
			  	<option value='2 months ago'<?php echo ($layout =='2 months ago')?'selected':''; ?>> <?php esc_html_e('2 months ago', 'gags-plugin'); ?> </option> 
			    <option value='3 months ago'<?php echo ($layout =='3 months ago')?'selected':''; ?>> <?php esc_html_e('3 months ago', 'gags-plugin'); ?> </option> 
			    <option value='6 months ago'<?php echo ($layout =='6 months ago')?'selected':''; ?>> <?php esc_html_e('6 months ago', 'gags-plugin'); ?> </option> 
			    <option value='1 year ago'<?php echo ($layout =='1 year ago')?'selected':''; ?>> <?php esc_html_e('1 year ago', 'gags-plugin'); ?> </option> 
			</select>
			</p>
	<?php
	}
}
?>