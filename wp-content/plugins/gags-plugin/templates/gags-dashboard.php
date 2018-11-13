<?php
/**
* The main template file for dashboard shortcode
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/templates
*/
?>

<?php if ( is_user_logged_in() ) : ?>
    <!-- Start : Main Content -->
    <?php get_gags_template_part( 'gags-user-info' ); // display user-info section ?>

    <div class="tab-nav">
        <?php
            $get_tabs_name = isset($_GET['tabs']) ? esc_attr( $_GET['tabs'] ) : '';
        ?>
        <a href="<?php the_permalink(); ?>?tabs=posts" data-content="#posts" class="<?php if ( $get_tabs_name == "posts" ) echo "active"; elseif (empty($get_tabs_name) ) echo "active"; ?>"><?php esc_html_e('Posts', 'gags-plugin'); ?></a>
        <a href="<?php the_permalink(); ?>?tabs=comments" data-content="#comments" class="<?php if ( $get_tabs_name == "comments" ) echo "active"; ?>"><?php esc_html_e('Comments', 'gags-plugin'); ?></a>
        <a href="<?php the_permalink(); ?>?tabs=likes" data-content="#likes" class="<?php if ( $get_tabs_name == "likes" ) echo "active"; ?>"><?php esc_html_e('Likes', 'gags-plugin'); ?></a>
    </div>

    <?php if ( $get_tabs_name == "posts" || $get_tabs_name == "" ) : ?>
    <div id="posts">
        <?php
            $user_ID = get_current_user_id(); // get current author
            query_posts(array( 
                'post_type'             => 'gag',
                'post_status'           => 'publish',
                'order'                 => 'desc',
                'author'                => $user_ID,
                'ignore_sticky_posts'   => 1,
                'paged'                 => gags_query_paged()
            ));

            // the loop
            if ( have_posts() ) :
            while ( have_posts() ) : the_post();
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
    <?php endif; ?>

    <?php if ( $get_tabs_name == "comments" ) : ?>
    <div id="comments">
        <?php
            $user_ID = get_current_user_id(); // get current author

            $args = array(
                'user_id'       => $user_ID, // comments by this user only
                'status'        => 'approve',
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
            
                foreach ($comments as $comment) :
        ?>
            <div class="commented-articles">
                <ul>
                    <li class="commented-article">
                        <div class="commented-article-detail">
                            <div class="commented-article-thumb">
                                <?php
                                    // display wordpress avatar
                                    $user = wp_get_current_user();
                                    $user_id = $user->ID;

                                    echo get_avatar( $user_id, 100 );    
                                ?>
                            </div>

                            <div class="comment-meta">
                                <span>
                                    <a href="<?php echo get_comment_link($comment->comment_ID); ?>" rel="external nofollow">
                                        <?php echo $comment->comment_author; ?>
                                    </a>
                                    <?php esc_html_e( ' commented:', 'upvote-plugin' ); ?> 
                                </span>
                            </div>
                        </div>

                        <div class="comment-entry">
                            <?php echo apply_filters( 'comment_text', '<i>'. wp_kses(  wp_trim_words(  $comment->comment_content, 30, ' ...'  ), $allowed_html ) .'</i> On' ); ?>
                        </div>

                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
                            <h3 class="post-title"><a href="<?php echo get_comment_link($comment->comment_ID); ?>" rel="external nofollow"><?php echo wp_trim_words( get_the_title( $comment->comment_post_ID ), 20, '...' ); ?></a></h3>
                            <?php
                            // Get external status
                            $gags_video_embed_url = get_post_meta( $comment->comment_post_ID, '_gag_video_embed_url', true );
                            if ( $gags_video_embed_url ) :
                                $gags_get_nfsw = get_post_meta( $comment->comment_post_ID, '_gag_nfsw', true );
                                if($gags_get_nfsw == 'on'){
                                    $thumb_image = "http://placehold.it/622x337/?text=".esc_html__('NSFW', 'gags-plugin');
                                    echo '<div class="thumbnail">';
                                        echo '<a href="'.get_comment_link($comment->comment_ID).'" title="'.get_the_title( $comment->comment_post_ID ).'" alt="'.get_the_title( $comment->comment_post_ID ).'">';
                                            echo '<img src="'.$thumb_image.'" alt="'.get_the_title( $comment->comment_post_ID ).'" title="'.get_the_title( $comment->comment_post_ID ).'">';
                                        echo '</a>';
                                    echo '</div>';
                                } else {
                            ?>
                                <div class="thumbnail">
                                    <a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
                                        <?php echo get_the_post_thumbnail( $comment->comment_post_ID, 'gags-post-thumbnail' ); ?>
                                    </a>
                                </div>
                        <?php
                                }
                            else :
                            
                            $get_img_ids = get_post_thumbnail_id($comment->comment_post_ID);
                            $type =  get_post_mime_type( $get_img_ids );
                            $mime_type = explode('/', $type);
                            $type = '.'.$mime_type['1'];
                        ?>
                            <?php if( $type == ".gif" ) : ?>
                                <?php
                                    $gags_get_nfsw = get_post_meta( $comment->comment_post_ID, '_gag_nfsw', true );
                                    if($gags_get_nfsw == 'on'){
                                        $thumb_image = "http://placehold.it/622x337/?text=".esc_html__('NSFW', 'gags-plugin');
                                        echo '<div class="thumbnail">';
                                            echo '<a href="'.get_comment_link($comment->comment_ID).'" title="'.get_the_title( $comment->comment_post_ID ).'" alt="'.get_the_title( $comment->comment_post_ID ).'">';
                                                echo '<img src="'. esc_url( $thumb_image ).'" alt="'.get_the_title( $comment->comment_post_ID ).'" title="'.get_the_title( $comment->comment_post_ID ).'">';
                                            echo '</a>';
                                        echo '</div>';
                                    } else {
                                ?>
                                    <div class="thumbnail gifplayer">
                                        <?php
                                            $image_attributes_gif = wp_get_attachment_image_src( get_post_thumbnail_id( $comment->comment_post_ID ), 'full' );
                                        ?>
                                        <?php the_post_thumbnail( 'gags-gif-thumbnail', array( 'data-gif' => $image_attributes_gif[0], 'title' => get_the_title( $comment->comment_post_ID ) ) ); ?>
                                    </div>
                                <?php } ?>
                            <?php else : ?>
                                <?php
                                    $gags_get_nfsw = get_post_meta( $comment->comment_post_ID, '_gag_nfsw', true );
                                    if($gags_get_nfsw == 'on'){
                                        $thumb_image = "http://placehold.it/622x337/?text=".esc_html__('NSFW', 'gags-plugin');
                                        echo '<div class="thumbnail">';
                                            echo '<a href="'.get_comment_link($comment->comment_ID).'" title="'.get_the_title( $comment->comment_post_ID ).'" alt="'.get_the_title( $comment->comment_post_ID ).'">';
                                                echo '<img src="'. esc_url( $thumb_image ).'" alt="'.get_the_title( $comment->comment_post_ID ).'" title="'.get_the_title( $comment->comment_post_ID ).'">';
                                            echo '</a>';
                                        echo '</div>';
                                    } else {
                                ?>
                                    <?php
                                    $image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $comment->comment_post_ID ), "gags-post-thumbnail" );
                                    $image_height = $image_data[2];
                                    if ($image_height > 800) {
                                    ?>
                                    <div class="thumbnail large">
                                        <a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
                                            <?php echo get_the_post_thumbnail( $comment->comment_post_ID, 'gags-post-thumbnail' ); ?>
                                        </a>
                                        <a class="view-full-post" href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
                                            <?php esc_html_e('View Full Post', 'gags-plugin'); ?>
                                        </a>
                                    </div>
                                    <?php } else { ?>
                                    <div class="thumbnail">
                                        <a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
                                            <?php echo get_the_post_thumbnail( $comment->comment_post_ID, 'gags-post-thumbnail' ); ?>
                                        </a>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php endif; ?>
                        <?php endif; ?>    

                            <?php
                                $author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>';
                                $num_comments = wp_count_comments( $comment->comment_post_ID );
                            ?>

                            <div class="article-footer">
                                <div class="vote-wrap">
                                    <?php
                                    // display post like button
                                    echo gags_getPostLikeLink( $comment->comment_post_ID );
                                    ?>
                                    <a class="comment-count" href="<?php the_permalink($comment->comment_post_ID); ?>"><i class="fa fa-comments"></i> <?php comments_number( esc_html__( '0 Comment', 'gags'), esc_html__( '1 Comment', 'gags'), esc_html__( '% Comments', 'gags') ); ?></a>
                                </div>
                                <div class="article-share">
                                    <span><a target="_blank" style="background-color: #2a54b2;" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink( $comment->comment_post_ID ) ); ?>&amp;t=<?php echo str_replace( ' ', '%20', get_the_title( $comment->comment_post_ID ) ); ?>"><i class="fa fa-facebook"></i></a></span>
                                    <span><a target="_blank" style="background-color: #3b9fe5;" href="http://twitter.com/share?url=<?php echo urlencode(get_permalink( $comment->comment_post_ID )); ?>&amp;text=<?php echo str_replace( ' ', '%20', get_the_title( $comment->comment_post_ID ) ); ?>&amp;count=horizontal"><i class="fa fa-twitter"></i></a></span>
                                    <?php $pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( $comment->comment_post_ID ), 'full' ); ?>
                                    <span><a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink( $comment->comment_post_ID ) ); ?>&amp;media=<?php echo $pinterestimage[0]; ?>&amp;description=<?php echo str_replace( ' ', '%20', get_the_title( $comment->comment_post_ID ) ); ?>" count-layout="vertical" style="background-color: #b22a2a;"><i class="fa fa-pinterest"></i></a></span>
                                </div>
                            </div>
                            <div class="entry-meta">
                                <span class="author">
                                    <i class="fa fa-user"></i>
                                    <?php echo $author; ?>
                                </span>
                                <!-- <span class="post-view"><?php echo gags_get_post_views($comment->comment_post_ID); ?></span>     -->
                                <span class="date">
                                    <i class="fa fa-clock-o"></i>
                                    <?php echo human_time_diff( get_the_modified_date('U'), current_time('timestamp') ) . esc_html__(' ago', 'gags'); ?>
                                </span>
                            </div>
                        </article>
                     </li>
                </ul>
            </div>
        <?php
                endforeach;
                get_gags_template_part( 'pagination' ); // display pagination section
            else :
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
                <div class="alert alert-warning">
                    <?php esc_html_e( "You don't have commented gags.", "gags-plugin" ); ?>
                </div>
            </article>
        <?php
            endif;
        ?>
    </div>
    <?php endif; ?>

    <?php if ( $get_tabs_name == "likes" ) : ?>
    <div id="likes">
        <?php
            $user_likes = get_user_option( "_liked_posts", get_current_user_id() );
            if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) {
                $the_likes = implode( ',', (array)$user_likes );
            } else {
                $the_likes = '';
            }

            $access_ids = $the_likes;

            $voted_ids = array_map( 'trim', explode( ',', $access_ids ) ); // right
            $exclude_ids = $voted_ids;

            $user_ID = get_current_user_id(); // get current author
            query_posts(array( 
                'post_type'             => 'gag',
                'post_status'           => 'publish',
                'order'                 => 'desc',
                'post__in'              => $exclude_ids,
                'ignore_sticky_posts'   => 1,
                'paged'                 => gags_query_paged()
            ));

            // the loop
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    get_gags_template_part( 'content-gag' ); // get content template
                endwhile;
                get_gags_template_part( 'pagination' ); // display pagination section
            else :
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post hentry clearfix' ); ?>>
                <div class="alert alert-warning">
                    <?php esc_html_e( "You don't have liked gags.", "gags-plugin" ); ?>
                </div>
            </article>
        <?php
            endif;
        ?>
        <?php wp_reset_query(); ?>
    </div>
    <?php endif; ?>
        
<?php else : ?>
    <article class="post hentry clearfix"> 
        <div class="alert alert-danger">
            <?php esc_html_e( 'You must be logged in to see your dashboard.', 'gags-plugin' ); ?>
        </div>
    </article>
<?php endif; ?>