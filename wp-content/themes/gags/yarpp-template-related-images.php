<?php 
/**
 * Yarpp Related Images Templates
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>

<h4 class="widget-title"><?php esc_html_e('Related Gags', 'gags'); ?></h4>

<div class="yarpp-thumbnails-horizontal">
    <?php if ( have_posts()): ?>
        <ol>
            <?php while ( have_posts()) : the_post(); ?>
                <li>
                    <?php if( has_post_thumbnail() ) { ?>
                    <div class="thumbnail">
                        <a class="yarpp-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php
                            the_post_thumbnail( 'gags-popular-thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title() ) );
                        ?>
                        </a>
                    </div>
                    <?php } ?>
                    
                    <a class="yarpp-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words( get_the_title(), 5, '...' ); ?></a>
                </li>
            <?php endwhile; ?>  
        </ol>
    <?php else: ?>
        <p><?php esc_html_e( 'No related gag.', 'gags' ); ?></p>
    <?php endif; ?>
</div>