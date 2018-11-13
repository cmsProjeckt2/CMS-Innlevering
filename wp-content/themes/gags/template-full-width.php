<?php
/**
 * Template Name: Full Width
 * 
 * Template for displaying full width page.
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>
<?php get_header(); ?>

<!-- Start : Main Content -->
    <div id="main">
        <div class="container small-container clearfix">
            <div id="maincontent" class="fullwidth">
                
                <div class="content">
                    <?php
                    // The loop
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            get_template_part( 'content-page' ); // get content template
                        }
                    } else {
                        get_template_part( 'content', 'none' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End : Main Content -->
        
<?php get_footer(); ?>