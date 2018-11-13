<?php
/**
* The main template file for recent gags shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>
<?php
    query_posts(array( 
        'post_type'             => 'gag',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => 1,
        'paged'                 => gags_query_paged()
    ));

    // the loop
    if ( have_posts() ) :
        $count = 1; //set count post
        while ( have_posts() ) : the_post();
            get_gags_template_part( 'content-gag' ); // get content template
            if($count == 1): //if post 1
                ?><div class="gags-ads"><?php
                gags_display_ads('between_posts'); //display ads between_posts post 1 and 2
                ?></div><?php
            endif;
        $count++;
        endwhile;
        get_gags_template_part( 'pagination' ); // display pagination section
    else :
?>
    <article class="post hentry clearfix">
        <div class="alert alert-warning">
            <?php esc_html_e( "No recent gags found.", "gags" ); ?>
        </div>
    </article>
<?php
    endif;
?>
<?php wp_reset_query(); ?>