<?php
/**
* The main template file for author page
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>
<?php get_header(); ?>

<!-- Start : Main Content -->
<div id="main">

    <div class="container clearfix">

        <?php get_gags_template_part( 'gags-user-info' ); // display user-info section ?>

        <div id="maincontent"> 

            <div id="posts">
                <?php
                    remove_action('pre_get_posts', 'gags_author_archive_paged');
                    $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                    $user_ID = $author->ID; // get current author
                    $args = array(
                        'post_type'             => 'gag',
                        'post_status'           => 'publish',
                        'order'                 => 'desc',
                        'author'                => $user_ID,
                        'ignore_sticky_posts'   => 1,
                        'paged'                 => gags_query_paged()
                    );

                    $wp_query = new WP_Query( $args );

                     // the loop
                    if ( $wp_query->have_posts() ) :
                        while ( $wp_query->have_posts() ) : $wp_query->the_post();
                            get_gags_template_part( 'content-gag' ); // get content template
                        endwhile;
                        get_gags_template_part( 'pagination' ); // display pagination section
                    else :
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
                        <div class="alert alert-warning">
                            <?php esc_html_e( "You don't have submitted gags.", "gags-plugin" ); ?>
                        </div>
                    </article>
                <?php
                    endif;
                ?>
                <?php wp_reset_query(); ?>
            </div>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>
<!-- End : Main Content -->

<?php get_footer(); ?>