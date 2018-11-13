<?php
/**
 * Function to collect the title of the current page
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_archive_title' ) ) {
	function gags_archive_title() {
		global $wp_query;

		$title = '';
		if ( is_category() ) :
			$title = sprintf( esc_html__( 'Category: %s', 'gags' ), single_cat_title( '', false ) );
		elseif ( is_tag() ) :
			$title = sprintf( esc_html__( 'Tag: %s', 'gags' ), single_tag_title( '', false ) );
		elseif ( is_single() ) :
			$title = wp_trim_words( get_the_title(), 10, ' ...' );
		elseif ( is_day() ) :
			$title = sprintf( esc_html__( '%© Daily Archives', 'gags' ), date_i18n( 'd', strtotime( get_the_date('Y-m-d'), false ) ) );
		elseif ( is_month() ) :
			$title = sprintf( esc_html__( '%s Monthly Archives', 'gags' ), date_i18n( 'F', strtotime( get_the_date('Y-m-d'), false ) ) );
		elseif ( is_year() ) :
			$title = sprintf( esc_html__( '%s Yearly Archives', 'gags' ), date_i18n( 'F', strtotime( get_the_date('Y-m-d'), false ) ) );
		elseif ( is_author() ) :
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$title = sprintf( esc_html__( '%s Author Archives', 'gags' ), get_the_author_meta( 'display_name', $author->ID ) );
		elseif ( is_search() ) :
			if ( $wp_query->found_posts ) {
				$title = sprintf( esc_html__( 'Search Keywords: "%s"', 'gags' ), esc_attr( get_search_query() ) );
			} else {
				$title = sprintf( esc_html__( 'Search Keywords: "%s"', 'gags' ), esc_attr( get_search_query() ) );
			}
		elseif ( get_post_format() ) :
			$title = sprintf( esc_html__( 'Post Format: %s', 'gags' ), get_post_format_string( get_post_format() ) );
		elseif ( is_404() ) :
			$title = esc_html__( 'Not Found', 'gags' );
		elseif ( is_home() || is_front_page() || is_single() ) :
			$title = esc_html__( 'Blog', 'gags' );
		else :
			$title = get_the_title();
		endif;
		
		return $title;
	}
}

/**
 * Function to load comment list
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_comment_list' ) ) {
	function gags_comment_list( $comment, $args, $depth ) {
		global $post;
		$author_post_id = $post->post_author;
		$GLOBALS['comment'] = $comment;

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
		
		switch ( $comment->comment_type ) :
			case '' :
	?>		
			<li id="comment-<?php comment_ID() ?>" class="clearfix">
				<div class="thumbnail">
				<?php 
			        // display wordpress avatar
		            $current_user_id = $comment->user_id;
					echo get_avatar( $current_user_id, 70 );
				?>	
				</div>
				<div class="detail">
					<h5><?php comment_author(); ?></h5>

					<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="moderate"><?php esc_html_e( 'Your comment is now awaiting moderation before it will appear on this post.', 'gags' ); ?></p>
					<?php endif; ?>
					<p><?php echo apply_filters( 'comment_text', wp_kses( get_comment_text(), $allowed_html ) );  ?></p>

					<div class="comment-footer">
						<span><?php echo get_comment_date( 'F d, Y h.i a' ); ?></span>
						<p class="replies">
							<span><i class="fa fa-reply"></i> <?php echo comment_reply_link( array( 'reply_text' => esc_html__( 'Reply', 'gags' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) );  ?></span>&nbsp;
							<?php if ( is_user_logged_in() ) : ?>
								<span><i class="fa fa-edit"></i> <?php edit_comment_link( esc_html__( 'Edit', 'gags' ), '', '' ); ?></span>
							<?php endif; ?>
						</p>
					</div>
				</div>	
			</li>

	<?php
			break;
			case 'pingback'  :
			case 'trackback' :
	?>
			<li id="comment-<?php comment_ID() ?>" class="clearfix">
				<div class="thumbnail">
				<?php 
			        // display wordpress avatar
		            $current_user_id = $comment->user_id;
					echo get_avatar( $current_user_id, 70 );
				?>	
				</div>
				<div class="detail">
					<h5><?php comment_author(); ?></h5>

					<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="moderate"><?php esc_html_e( 'Your comment is now awaiting moderation before it will appear on this post.', 'gags' );?></p>
					<?php endif; ?>
					<p><?php echo apply_filters( 'comment_text', wp_kses( get_comment_text(), $allowed_html ) );  ?></p>

					<div class="comment-footer">
						<span><?php echo get_comment_date( 'F d, Y h.i a' ); ?></span>
						<p class="replies">
							<span><i class="fa fa-reply"></i> <?php echo comment_reply_link( array( 'reply_text' => esc_html__( 'Reply', 'gags' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) );  ?></span>&nbsp;
							<?php if ( is_user_logged_in() ) : ?>
								<span><i class="fa fa-edit"></i> <?php edit_comment_link( esc_html__( 'Edit', 'gags' ), '', '' ); ?></span>
							<?php endif; ?>
						</p>
					</div>
				</div>	
			</li>	
	<?php
			break;
		endswitch;
	}
}

if ( ! function_exists( 'gags_move_comment_field_to_bottom' ) ) {
	function gags_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
}
add_filter( 'comment_form_fields', 'gags_move_comment_field_to_bottom' );

if ( ! function_exists( 'gags_check_referrer' ) ) {
	function gags_check_referrer() {
	    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == “”) {
	        wp_die( esc_html__( 'Please enable referrers in your browser, or, if you\'re a spammer, get out of here!', 'gags' ) );
	    }
	}
}
add_action('check_comment_flood', 'gags_check_referrer');

if ( ! function_exists( 'gags_comment_form_top' ) ) {
	function gags_comment_form_top() {
}
	add_action( 'comment_form_top', 'gags_comment_form_top' );

	function gags_comment_form_bottom() {
	}
}
add_action( 'comment_form', 'gags_comment_form_bottom', 1 );

/**
 * Function to get the first link from a post. Based on the codes from WP Recipes 
 * http://www.wprecipes.com/wordpress-tip-how-to-get-the-first-link-in-post
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_get_link_url' ) ) {
	function gags_get_link_url() {
	    $content = get_the_content();
	    $has_url = get_url_in_content( $content );

	    return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}

/**
 * Function to get post views
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_get_post_views' ) ) {
	function gags_get_post_views($postID){
		$gags_count_key = 'post_views_count';
	    $gags_get_count = get_post_meta( $postID, $gags_count_key, true );
	    $text_views = esc_html__( ' Views', 'gags' );
	    $text_view 	= esc_html__( ' View', 'gags' );
	    if( $gags_get_count == '' ){
	        delete_post_meta( $postID, $gags_count_key );
	        add_post_meta( $postID, $gags_count_key, '0' );
	        return "0".$text_view;
	    }
	    return $gags_get_count.$text_views;
	}
}

/**
 * Function to set post views
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_set_post_views' ) ) {
	function gags_set_post_views( $postID ) {
	    $gags_count_key = 'post_views_count';
	    $gags_get_count = get_post_meta($postID, $gags_count_key, true);
	    if($gags_get_count == '' ){
	        $gags_get_count = 0;
	        delete_post_meta( $postID, $gags_count_key );
	        add_post_meta( $postID, $gags_count_key, '0' );
	    }else{
	        $gags_get_count++;
	        update_post_meta( $postID, $gags_count_key, $gags_get_count );
	    }
	}
}

/**
 * Function to display post meta
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_post_meta' ) ) {
	function gags_post_meta() {
?>	
		<div class="entry-meta">
			<span class="avatar">
				<?php echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>'; ?>
			</span>
			<span class="post-view"><?php echo gags_get_post_views(get_the_ID()); ?></span>	
			<span class="date">
				<?php echo human_time_diff( get_the_modified_date('U'), current_time('timestamp') ) . esc_html__(' ago', 'gags'); ?>
			</span>
			<span class="comment-count"><a href="<?php the_permalink(); ?>"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a></span>
		</div>
<?php
	}
}

/**
 * Function to display post sharing
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_post_sharing' ) ) {
	function gags_post_sharing() {
?>
	<div class="article-share">
		<?php esc_html_e( 'Share', 'gags' ); ?> 
		<span><a target="_blank" href="<?php echo esc_url( 'https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink( get_the_ID() ) )); ?>&amp;t=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>"><i class="fa fa-facebook"></i></a></span>
		<span><a target="_blank" href="<?php echo esc_url( 'http://twitter.com/share?url=' . urlencode(get_permalink( get_the_ID() ))); ?>&amp;text=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>&amp;count=horizontal"><i class="fa fa-twitter"></i></a></span>
	</div>
<?php
	}
}

/**
 * Change default excerpt more text
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if( !function_exists( 'gags_excerpt_more ') ) {
	function gags_excerpt_more( ) {
		return ' ...';
	}
}
add_filter( 'excerpt_more', 'gags_excerpt_more', 999 );

/**
 * Change default excerpt length
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( !function_exists( 'gags_excerpt_length ') ) {
	function gags_excerpt_length( $length ) {
		global $gags_option;
		if (!empty($gags_option['gags_post_excerpt_length'])) :
			return absint($gags_option['gags_post_excerpt_length']);
		else :
			return 60;
		endif;
	}
}
add_filter( 'excerpt_length', 'gags_excerpt_length', 999 );


/**
 * Function to set custom logout menu on account navigation
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_add_loginlogout_link($items, $args)
{
//defaults; change this as you see fit
$defaults = array(
	'loginlout_position' => 999, //enter 0 for front, 999 for end
	'menu_id' => 'menu-item', //custom CSS
	'menu_class' => 'menu-item menu-item-type-custom menu-item-object-custom', //custom CSS
	'menu_location' =>'gags-account-navigation', //enter primary, secondary, or topnav for News
	'loginredirect' => false //enter true for redirect to wp-admin dashboard
);

//do nothing if not proper menu location
if( $args->theme_location != $defaults['menu_location'] )
return $items;

//set redirect URL
if( $defaults['loginredirect'] )
	$wpurl = 'wp-admin/index.php';
else
	$wpurl = 'index.php';

// split the menu items into an array using the ending <li> tag
if ( $defaults['loginlout_position'] != 0 && $defaults['loginlout_position'] != 1 && $defaults['loginlout_position'] != 999 ) {
	$items = explode('</li>',$items);
}

if(is_user_logged_in())
{
	$newitem = '<li id="'.$defaults['menu_id'].'" class="'.$defaults['menu_class'].'"><a title="'. esc_html__('Logout', 'gags').'" href="'. wp_logout_url($wpurl) .'">'.esc_html__('Logout', 'gags').'</a></li>';
	if ( $defaults['loginlout_position'] == 0 || $defaults['loginlout_position'] == 1 )
		$newitems = $newitem.$items;
	elseif ( $defaults['loginlout_position'] == 999 )
		$newitems = $items.$newitem;
else
	$newitem = '<li id="'.$defaults['menu_id'].'" class="'.$defaults['menu_class'].'">' . $args->before . '<a title="'.esc_html__('Logout', 'gags').'" href="'. wp_logout_url('index.php') .'">' . $args->link_before . 'Logout' . $args->link_after . '</a>' . $args->after; // no </li> needed this is added later
}
else
{
	$gags_login_pages = get_option('gags_plugin_page_setting');

	if ($gags_login_pages['gags_login_page'] != 'http://#') {
		$newitem = '<li id="'.$defaults['menu_id'].'" class="'.$defaults['menu_class'].'"><a title="'.esc_html__('Login', 'gags').'" href="'.esc_url( $gags_login_pages['gags_login_page'] ).'">'.esc_html__('Login', 'gags').'</a></li>';
	}
	if ( $defaults['loginlout_position'] == 0 || $defaults['loginlout_position'] == 1 )
		$newitems = $newitem.$items;
	elseif ( $defaults['loginlout_position'] == 999 )
		$newitems = $items.$newitem;
else
	if ( $gags_login_pages['gags_login_page'] != 'http://#' ) :
		$newitem = '<li id="'.$defaults['menu_id'].'" class="'.$defaults['menu_class'].'">' . $args->before . '<a title="'.esc_html__('Login', 'gags').'" href="'.esc_url( $gags_login_pages['gags_login_page'] ).'">' . $args->link_before . esc_html__('Login', 'gags') . $args->link_after . '</a>' . $args->after; // no </li> needed this is added later
	endif;
}

if ( $defaults['loginlout_position'] != 0 && $defaults['loginlout_position'] != 1 && $defaults['loginlout_position'] != 999 ) {
	$newitems = array();

	// loop through the menu items, and add the new link at the right position
	foreach($items as $index => $item)
	{
	// array indexes are always one less than the position (1st item is index 0)
	if($index == $defaults['loginlout_position']-1)
	{
		$newitems[] = $newitem;
	}
	$newitems[] = $item;
	}

	// finally put all the menu items back together into a string using the ending <li> tag and return
	$newitems = implode('</li>',$newitems);
}
	return $newitems;
}
add_filter('wp_nav_menu_items', 'gags_add_loginlogout_link', 10, 2);
add_filter('genesis_nav_items', 'gags_add_loginlogout_link', 10, 2); //non-Genesis users delete this line.

/**
 * Function to set last login status
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_last_login($login) {
    global $user_ID;
    $user = get_user_by( 'login', $login );
    update_user_meta($user->ID, 'last_login', current_time('mysql'));
}
add_action('wp_login','gags_last_login');

/**
 * Function to get last login status
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_get_last_login($user_id) {
    $last_login = get_user_meta($user_id, 'last_login', true);
    $date_format = get_option('date_format') . ' ' . get_option('time_format');
    $the_last_login = mysql2date($date_format, $last_login, false);
    echo $the_last_login;
}

/**
 * Function to set default embed size
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_embed_defaults($embed_size){

    $embed_size['width'] = 1000; // Adjust values to your needs
    $embed_size['height'] = 300; 

    return $embed_size; // Return new size 
}
add_filter('embed_defaults', 'gags_embed_defaults');

/**
 * Function to display post sharing
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_sharing' ) ) {
	function gags_sharing() {
?>
	<div class="article-share">
		<span><a target="_blank" style="background-color: #2a54b2;" href="<?php echo esc_url('https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink( get_the_ID() ) )); ?>&amp;t=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>"><i class="fa fa-facebook"></i></a></span>
		<span><a target="_blank" style="background-color: #3b9fe5;" href="<?php echo esc_url('http://twitter.com/share?url=' . urlencode(get_permalink( get_the_ID() ))); ?>&amp;text=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>&amp;count=horizontal"><i class="fa fa-twitter"></i></a></span>
		<?php $gags_pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
		<span><a target="_blank" href="<?php echo esc_url('http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink( get_the_ID() ) )); ?>&amp;media=<?php echo esc_url($gags_pinterestimage[0]); ?>&amp;description=<?php echo str_replace( ' ', '%20', get_the_title() ); ?>" count-layout="vertical" style="background-color: #b22a2a;"><i class="fa fa-pinterest"></i></a></span>
	</div>
<?php
	}
}

/**
 * Function to display advertising feature
 *
 * @package WordPress
 * @subpackage Newmagz
 * @since Newmagz 1.0.0
 */
if ( ! function_exists( 'gags_display_ads' ) ) {
	function gags_display_ads($ads) {
		global $gags_option;
		
		if($ads == 'between_posts'):
			$between_posts_ads_mode = $gags_option['between_posts_ads_mode'];
			$between_posts_ads_banner = $gags_option['between_posts_ads_img'];

			$ad_300 = '';

			if( isset($between_posts_ads_banner['width']) || isset($between_posts_ads_banner['height']) ) {
				$between_posts_ads_banner['width'] = $between_posts_ads_banner['width'];
				$between_posts_ads_banner['height'] = $between_posts_ads_banner['height'];
			} else {
				$between_posts_ads_banner['width'] = '300';
				$between_posts_ads_banner['height'] = '250';
			}

			if ( $between_posts_ads_mode == 1 ) :
				if ( is_array($between_posts_ads_banner) && $between_posts_ads_banner['url'] ) :
					$ad_300 = '<a href="' . esc_url( $gags_option['between_posts_ads_url'] ? $gags_option['between_posts_ads_url'] : '#' ) . '" target="_blank"><img src="' . esc_url( $between_posts_ads_banner['url'] ) . '" width="'. absint( $between_posts_ads_banner['width'] ).'" height="'. absint( $between_posts_ads_banner['height'] ) .'" alt=""/></a>';
				endif;
			else :
				$ad_300 = $gags_option['between_posts_ads_code'];
			endif;

			if ( $ad_300 ) :
				echo $ad_300;
			endif;
		elseif($ads == 'single_gag'):
			$single_posts_ads_mode = $gags_option['single_posts_ads_mode'];
			$single_posts_ads_banner = $gags_option['single_posts_ads_img'];

			$ad_300 = '';

			if( isset($single_posts_ads_banner['width']) || isset($single_posts_ads_banner['height']) ) {
				$single_posts_ads_banner['width'] = $single_posts_ads_banner['width'];
				$single_posts_ads_banner['height'] = $single_posts_ads_banner['height'];
			} else {
				$single_posts_ads_banner['width'] = '300';
				$single_posts_ads_banner['height'] = '250';
			}

			if ( $single_posts_ads_mode == 1 ) :
				if ( is_array($single_posts_ads_banner) && $single_posts_ads_banner['url'] ) :
					$ad_300 = '<a href="' . esc_url( $gags_option['single_posts_ads_url'] ? $gags_option['single_posts_ads_url'] : '#' ) . '" target="_blank"><img src="' . esc_url( $single_posts_ads_banner['url'] ) . '" width="'. absint( $single_posts_ads_banner['width'] ).'" height="'. absint( $single_posts_ads_banner['height'] ) .'" alt=""/></a>';
				endif;
			else :
				$ad_300 = $gags_option['single_posts_ads_code'];
			endif;

			if ( $ad_300 ) :
				echo $ad_300;
			endif;
		endif;

}}

/**
 * Function Pagination Query
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_query_paged' ) ) {
	function gags_query_paged() {
		global $paged;
		if ( get_query_var('paged') ) {
	        $paged = get_query_var('paged');
	    } elseif ( get_query_var('page') ) {
	        $paged = get_query_var('page');
	    } else {
	        $paged = 1;
	    }
	    return $paged;
	}
}

/**
 * Function Android Bar Background Color
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if ( ! function_exists( 'gags_android_header_color' ) ) {
	function gags_android_header_color() {
		global $gags_option;
		$header_bg_color = $gags_option['gags_header_background']['background-color'];
?>
		<!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="<?php echo esc_attr($header_bg_color); ?>">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="<?php echo esc_attr($header_bg_color); ?>">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<?php
	}
}

/**
 * Function to remove query string jquery version 
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
function gags_remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', 'gags_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'gags_remove_script_version', 15, 1 );

/**
 * Defer jQuery Parsing using the HTML5 defer property
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
if (!(is_admin() )) {
    function gags_defer_parsing_of_js ( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;
        if ( strpos( $url, 'jquery.js' ) ) return $url;
        // return "$url' defer ";
        return "$url' defer onload='";
    }
    add_filter( 'clean_url', 'gags_defer_parsing_of_js', 11, 1 );
}

/**
 * Function to add custom classes to the body
 *
 * @package WordPress
 * @subpackage Gags
 * @since Gags 1.0.0
 */
add_filter( 'body_class', 'gags_custom_body_classes' );
function gags_custom_body_classes( $classes ) {
  	if ( is_home() ) {
        $classes[] = 'homepage';
    }
    return $classes;
}
?>