<?php
/**
* Gags top author widgets
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/
 
// Widgets
add_action( 'widgets_init', 'gags_top_author_widget' );

// Register our widget
function gags_top_author_widget() {
    register_widget( 'Gags_Top_Author' );
}

// Warrior Latest Video Widget
class Gags_Top_Author extends WP_Widget {

    //  Setting up the widget
    function Gags_Top_Author() {
        $widget_ops  = array( 'classname' => 'gags_top_author_widget', 'description' => esc_html__('Display top week\'s active users.', 'gags-plugin') );
        $control_ops = array( 'id_base' => 'gags_top_author' );

        parent::__construct( 'gags_top_author', esc_html__('Gags - Active Users', 'gags-plugin'), $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {
        
        extract( $args );

        $gags_top_author_title = apply_filters( 'widget_title', empty( $instance['gags_top_author_title'] ) ? esc_html__( "This week's active users", "gags-plugin" ) : $instance['gags_top_author_title'], $instance, $this->id_base );
        $gags_top_author_limit = !empty( $instance['gags_top_author_limit'] ) ? absint( $instance['gags_top_author_limit'] ) : 5;
        if(!empty($instance['gags_range_time'])){
        $gags_range_time = esc_attr($instance['gags_range_time'] );
        }
?>
        <?php echo $before_widget; ?>
        <?php echo $before_title . $gags_top_author_title . $after_title; ?>
<?php
    global $wpdb;
        
    $top_authors = $wpdb->get_results("
        SELECT u.ID, count(post_author) as posts FROM {$wpdb->posts} as p
        LEFT JOIN {$wpdb->users} as u ON p.post_author = u.ID
        WHERE p.post_status = 'publish'
        AND p.post_type = 'gag'
        AND p.post_date > '" . date('Y-m-d H:i:s', strtotime((!empty($gags_range_time)))) . "'
        GROUP by p.post_author
        ORDER by posts DESC
        LIMIT 0,$gags_top_author_limit
    ");
?>
    <div class="active-users-widget">
    <?php
        if( !empty( $top_authors ) ) {
            echo '<ul class="clearfix">';
            foreach( $top_authors as $key => $author ) :
                echo '<li>';
                    global $wp_query;
                    $current_author = $wp_query->get_queried_object();
                    $current_author_meta = get_user_meta( $author->ID );
                    // Author profile image
                    if(function_exists('get_avatar')) {
                        echo '<a href="' . get_author_posts_url( $author->ID ) . '">' . get_avatar( $author->ID, '60' ) . '</a><span>'. get_the_author_meta( 'display_name' , $author->ID ) .'</span>';
                    }
                echo '</li>';
            endforeach;
            echo '</ul>';
        } else {
            echo esc_html__('No have active users found.', 'gags-plugin');
        }  
    ?>
    </div>
        <?php echo $after_widget; ?>
<?php
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['gags_top_author_title']     = strip_tags( $new_instance['gags_top_author_title'] );
        $instance['gags_top_author_limit']     = (int) $new_instance['gags_top_author_limit'];
        $instance['gags_range_time']           = esc_attr($new_instance['gags_range_time']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array('gags_top_author_title' => esc_html__("This week's active users", "gags-plugin"), 'gags_top_author_limit' => '5', 'gags_range_time' => '- 7 days') );
    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_top_author_title' ); ?>"><?php esc_html_e('Widget Title:', 'gags-plugin'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_top_author_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_top_author_title' ); ?>" value="<?php echo $instance['gags_top_author_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gags_top_author_limit' ); ?>"><?php esc_html_e('Number of user to display:', 'gags-plugin'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'gags_top_author_limit' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gags_top_author_limit' ); ?>" value="<?php echo $instance['gags_top_author_limit']; ?>" />
        </p>
        <p>
   
            <label for="<?php echo $this->get_field_id( 'gags_range_time' ); ?>"><?php esc_html_e('Post Date Range:', 'gags-plugin'); ?></label>
            <?php $layout = $instance['gags_range_time']; echo $layout; ?>
            <select class='widefat' id="<?php echo $this->get_field_id('gags_range_time'); ?>" name="<?php echo $this->get_field_name('gags_range_time'); ?>" type="text">
                <option value="- 1 day"<?php echo ($layout =="- 1 day")?'selected':''; ?>> <?php esc_html_e('1 day ago', 'gags-plugin'); ?> </option>
                <option value="- 2 days"<?php echo ($layout =="- 2 days")?'selected':''; ?>> <?php esc_html_e('2 days ago', 'gags-plugin'); ?> </option> 
                <option value="- 3 days"<?php echo ($layout =="- 3 days")?'selected':''; ?>> <?php esc_html_e('3 days ago', 'gags-plugin'); ?> </option> 
                <option value="- 4 days"<?php echo ($layout =="- 4 days")?'selected':''; ?>> <?php esc_html_e('4 days ago', 'gags-plugin'); ?> </option> 
                <option value="- 5 days"<?php echo ($layout =="- 5 days")?'selected':''; ?>> <?php esc_html_e('5 days ago', 'gags-plugin'); ?> </option> 
                <option value="- 6 days"<?php echo ($layout =="- 6 days")?'selected':''; ?>> <?php esc_html_e('6 days ago', 'gags-plugin'); ?> </option>
                <option value="- 7 days"<?php echo ($layout =="- 7 days")?'selected':''; ?>> <?php esc_html_e('7 days ago', 'gags-plugin'); ?> </option> 
                <option value="- 1 week"<?php echo ($layout =="- 1 week")?'selected':''; ?>> <?php esc_html_e('1 week ago', 'gags-plugin'); ?> </option> 
                <option value="- 2 weeks"<?php echo ($layout =="- 2 weeks")?'selected':''; ?>> <?php esc_html_e('2 weeks ago', 'gags-plugin'); ?> </option> 
                <option value="- 1 month"<?php echo ($layout =="- 1 month")?'selected':''; ?>> <?php esc_html_e('1 month ago', 'gags-plugin'); ?> </option> 
                <option value="- 2 months"<?php echo ($layout =="- 2 months")?'selected':''; ?>> <?php esc_html_e('2 months ago', 'gags-plugin'); ?> </option> 
                <option value="- 3 months"<?php echo ($layout =="- 3 months")?'selected':''; ?>> <?php esc_html_e('3 months ago', 'gags-plugin'); ?> </option> 
                <option value="- 6 months"<?php echo ($layout =="- 6 months")?'selected':''; ?>> <?php esc_html_e('6 months ago', 'gags-plugin'); ?> </option> 
                <option value="- 1 year"<?php echo ($layout =="- 1 year")?'selected':''; ?>> <?php esc_html_e('1 year ago', 'gags-plugin'); ?> </option> 
            </select>
        </p>
    <?php
    }
}
?>