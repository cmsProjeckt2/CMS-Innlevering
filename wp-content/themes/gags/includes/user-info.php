<?php
/**
 * The Template for displaying user information
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<div id="dashboard-header">
    <div class="profile">
        <?php
        // display wordpress avatar
            if( is_author() ) {
                // Get current author
                $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                $user_id = $author->ID; // get current author
            } elseif( is_page() ) {
                $user_id = get_current_user_id();
            }
        ?>
        <div class="thumbnail">
            <?php
                echo get_avatar( $user_id, 100 );
            ?>
        </div>
        <div class="info">
            <h2><?php echo get_the_author_meta( "first_name", $user_id ); ?> <?php echo get_the_author_meta( "last_name", $user_id ); ?> <small> <?php if ( function_exists( 'gags_get_user_last_login' ) ) { echo gags_get_user_last_login($user_id); } ?></small></h2>
        </div>
    </div>

    <div class="profile-info">
        <ul>
            <?php if ( function_exists( 'gags_get_auth_post_count' ) ) : ?>
            <li>
                <p><?php echo gags_get_auth_post_count(); ?><small><?php esc_html_e('Posts', 'gags'); ?></small></p>
            </li>
            <?php endif; ?>
            <?php if ( function_exists( 'gags_get_auth_comment_count' ) ) : ?>
            <li>
                <p><?php echo gags_get_auth_comment_count(); ?><small><?php esc_html_e('Comments', 'gags'); ?></small></p>
            </li>
            <?php endif; ?>
            <?php if ( function_exists( 'gags_get_auth_voted_count' ) ) : ?>
            <li>
                <p><?php echo gags_get_auth_voted_count(); ?><small><?php esc_html_e('Likes', 'gags'); ?></small></p>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="clearfix"></div>    
</div>