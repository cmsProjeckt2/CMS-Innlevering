<?php
/**
 * The main template file for dashborad user.
 *
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
?>
<?php get_header(); ?>

<!-- Start : Main Content -->
<div id="main">

	<div class="container clearfix">
        <?php get_template_part( 'includes/user-info' ); // display user-info section ?>

        <div id="maincontent">
            <div class="tab-nav">
                <?php $get_tabs_name = esc_attr( isset($_GET['tabs']) ? esc_attr( $_GET['tabs'] ) : '' ); ?>
                <a href="?tabs=posts" data-content="#posts" class="<?php if ( $get_tabs_name == "posts" ) echo "active"; elseif (empty($get_tabs_name) ) echo "active"; ?>"><?php esc_html_e('Posts', 'gags'); ?></a>
                <a href="?tabs=comments" data-content="#comments" class="<?php if ( $get_tabs_name == "comments" ) echo "active"; ?>"><?php esc_html_e('Comments', 'gags'); ?></a>
            </div>  

            <?php 
            // paged
            if ( get_query_var('paged') ) {
                $paged = get_query_var('paged');
            } elseif ( get_query_var('page') ) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
            ?>

            <div id="posts" class="tab-content" style="<?php if ( $get_tabs_name == "posts" ) echo "display:block;"; elseif (empty($get_tabs_name) ) echo "display:block;"; ?>">
                <?php
                    $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                	$user_ID = $author->ID; // get current author
                    $args = array(
                        'post_type'             => 'post',
                        'post_status'           => 'publish',
                        'order'                 => 'desc',
                        'author'                => $user_ID,
                        'ignore_sticky_posts'   => 1,
                        'paged'                 => $paged
                    );

                    $wp_query = new WP_Query( $args );

                    // the loop
                    if ( $wp_query->have_posts() ) :
                        while ( $wp_query->have_posts() ) : $wp_query->the_post();
                            get_template_part( 'content' ); // get content template
                        endwhile;
                        get_template_part( 'includes/pagination' ); // display pagination section
                    else :
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
                        <div class="alert alert-warning">
                            <?php esc_html_e( "You don't have submitted posts.", "gags" ); ?>
                        </div>
                    </article>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            </div>

            <div id="comments" class="tab-content" style="<?php if ( $get_tabs_name == "comments" ) echo "display:block;"; ?>">
                <?php
                $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                $user_ID = $author->ID; // get current author
                $args = array(
                    'user_id'       => $user_ID, // comments by this user only
                    'status'        => 'approve',
                    'post_type'     => 'post',
                    'post_status'   => 'publish',
                    'number'        => 10
                );

                $comments = get_comments( $args );

                if ( !empty( $comments ) ) :
                    // Allowed html tags will be display
                    $allowed_html = array(
                        'a' => array( 'href' => array(), 'title' => array() ),
                        'abbr' => array( 'title' => array() ),
                        'acronym' => array( 'title' => array() ),
                        'strong' => array(),
                        'b' => array(),
                        'blockquote' => array( 'cite' => array() ),
                        'cite' => array(),
                        'code' => array(),
                        'del' => array( 'datetime' => array() ),
                        'em' => array(),
                        'i' => array(),
                        'q' => array( 'cite' => array() ),
                        'strike' => array(),
                        'ul' => array(),
                        'ol' => array(),
                        'li' => array()
                    );
                ?>

                    <?php foreach ($comments as $comment) : ?>
                    <div class="commented-articles">
                        <ul>
                            <li class="commented-article">
                                <div class="commented-article-detail">
                                    <div class="commented-article-thumb">
                                        <?php echo gags_display_avatar(); ?>
                                    </div>

                                    <div class="comment-meta">
                                        <span>
                                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>" rel="external nofollow">
                                                <?php echo esc_attr($comment->comment_author); ?>
                                            </a>
                                            <?php echo esc_html( ' commented:', 'gags' ); ?> 
                                        </span>
                                    </div>
                                </div>

                                <div class="comment-entry">
                                    <?php echo apply_filters( 'comment_text', '<i>'. wp_kses(  wp_trim_words(  $comment->comment_content, 30, ' ...'  ), $allowed_html ) .'</i> On' ); ?>
                                </div>

                                <article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry post' ); ?>>
                                    <h3 class="post-title"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>" rel="external nofollow"><?php echo wp_trim_words( get_the_title( $comment->comment_post_ID ), 20, '...' ); ?></a></h3>
                                        <div class="thumbnail">
                                            <a href="<?php echo get_comment_link($comment->comment_ID); ?>">
                                                <?php echo get_the_post_thumbnail( $comment->comment_post_ID, 'gags-post-thumbnail' ); ?>
                                            </a>
                                            <div class="article-vote">
                                                <?php
                                                    // display post like button
                                                    echo gags_getPostLikeLink( $comment->comment_post_ID );
                                                ?>
                                            </div>
                                        </div>

                                        <?php
                                            $author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>';
                                            $num_comments = wp_count_comments( $comment->comment_post_ID );
                                        ?>

                                        <div class="entry-meta">
                                            <span class="author">
                                                <?php echo esc_html( $author ); ?>
                                            </span>
                                            <span class="post-view"><?php echo gags_get_post_views(get_the_ID()); ?></span> 
                                            <span class="date">
                                                <?php echo human_time_diff( get_the_modified_date('U'), current_time('timestamp') ) . esc_html__(' ago', 'gags'); ?>
                                            </span>
                                            <span class="comment-count">
                                                <a href="<?php the_permalink($comment->comment_post_ID); ?>"><i class="fa fa-comment"></i> <?php echo esc_attr( $num_comments->total_comments ); ?></a>
                                            </span>
                                        </div>

                                        <?php echo gags_sharing(); // display post sharing button ?>
                                </article>
                             </li>
                        </ul>
                    </div>

                    <?php endforeach; ?>
                    <?php get_template_part( 'includes/pagination' ); // display pagination section ?>

                <?php else : ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
                        <div class="alert alert-warning">
                            <?php esc_html_e( "You don't have commented posts.", "gags" ); ?>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>
<!-- End : Main Content -->

<?php get_footer(); ?>