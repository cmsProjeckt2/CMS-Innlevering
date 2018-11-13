<?php 
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */

// Do not delete these lines  
if ( post_password_required() ) {
    return;
}
?>

<?php if ( have_comments() ) : ?>

    <!-- START: COMMENT LIST -->
    <div id="comment-widget" class="comment-widget">
        <div class="comment-header">
            <h4 class="widget-title"><?php echo esc_html('Leave Your Comment', 'gags'); ?></h4>
        </div>
    
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <div class="navigation clearfix">
                <span class="prev"><?php previous_comments_link(esc_html__( '&larr; Previous', 'gags' ), 0); ?></span>
                <span class="next"><?php next_comments_link(esc_html__( 'Next &rarr;', 'gags' ), 0); ?></span>
            </div>  
        <?php endif; ?>
    </div>  
    <!-- END: COMMENT LIST -->
    
<?php else : // or, if we don't have comments: ?>      
<?php endif; // end have_comments() ?> 

<!-- START: Respond -->
<?php if ( comments_open() ) : ?>
    <div class="comment-widget">
        <!-- <h4 class="widget-title"><?php esc_html_e( 'Leave Your Comment', 'gags'); ?></h4> -->
        <?php 
        comment_form( array(
            'title_reply'           =>  '',
            'comment_notes_before'  =>  '',
            'comment_notes_after'   =>  '',
            'label_submit'          =>  esc_html__( 'Submit', 'gags' ),
            'cancel_reply_link'     =>  esc_html__( 'Cancel Reply', 'gags' ),
            'logged_in_as'          => '<p class="logged-user">' . sprintf( wp_kses( __( 'You are logged in as <a href="%1$s">%2$s</a> &#8212; <a href="%3$s">Logout &raquo;</a>', 'gags' ), array(  'a' => array( 'href' => array() ) ) ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
            'fields'                => array(
            'author'                =>  '<div class="input-group"><label for="fullname"><input type="text" value="" name="author" id="fullname" class="input" placeholder="'. esc_html__('Fullname', 'gags') .'"/></label></div>',
            'email'                 =>  '<div class="input-group"><label for="email"><input type="email" value="" name="email" id="email" class="input" placeholder="'. esc_html__('E-mail Address', 'gags') .'"/></label></div>',
            'url'                   =>  '<div class="input-group"><label for="weburl"><input type="url" name="url" id="weburl" class="input" value="" placeholder="'. esc_html__('Web URL', 'gags') .'"/></label></div>  '
                                    ),
            'comment_field'         =>  '<div class="input-group"><label for="comment"><textarea name="comment" id="comment" class="input textarea" placeholder="'. esc_html__('Comment', 'gags') .'"></textarea></label></div>',
            'label_submit'          => esc_html__(' Submit', 'gags')

            ));
        ?>
        <div class="clearfix"></div>
    </div>

    <div class="comments">
        <ul>
        <?php wp_list_comments( 'callback=gags_comment_list' ); ?>
        </ul>
    </div>
    <div class="clearfix"></div>
<?php endif; // END: Respond ?>