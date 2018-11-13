<?php
/**
* The create custom post type functions.
*
* @link       http://www.themewarrior.com
* @since      1.0.0
*
* @package    Gags_Plugin
* @subpackage Gags_Plugin/widgets
*/

// Custom Gags Taxonomy
function gags_taxonomies() {
    $labels = array(
        'name'              => esc_html__( 'Gags Categories', 'gags-plugin' ),
        'singular_name'     => esc_html__( 'Gags Category', 'gags-plugin' ),
        'search_items'      => esc_html__( 'Search Category', 'gags-plugin' ),
        'all_items'         => esc_html__( 'All Category', 'gags-plugin' ),
        'parent_item'       => esc_html__( 'Parent Category', 'gags-plugin' ),
        'parent_item_colon' => esc_html__( 'Parent Category:', 'gags-plugin' ),
        'edit_item'         => esc_html__( 'Edit Category', 'gags-plugin' ),
        'update_item'       => esc_html__( 'Update Category', 'gags-plugin' ),
        'add_new_item'      => esc_html__( 'Add New Category', 'gags-plugin' ),
        'new_item_name'     => esc_html__( 'New Category', 'gags-plugin' ),
        'menu_name'         => esc_html__( 'Categories', 'gags-plugin' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'gag-category' ),
    );

    register_taxonomy( 'gag_category', array( 'gag' ), $args );

    $labels = array(
        'name'              => esc_html__( 'Gags Tags', 'gags-plugin' ),
        'singular_name'     => esc_html__( 'Gags Tag', 'gags-plugin' ),
        'search_items'      => esc_html__( 'Search Tag', 'gags-plugin' ),
        'all_items'         => esc_html__( 'All Tag', 'gags-plugin' ),
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => esc_html__( 'Edit Tag', 'gags-plugin' ),
        'update_item'       => esc_html__( 'Update Tag', 'gags-plugin' ),
        'add_new_item'      => esc_html__( 'Add New Tag', 'gags-plugin' ),
        'new_item_name'     => esc_html__( 'New Tag', 'gags-plugin' ),
        'menu_name'         => esc_html__( 'Tags', 'gags-plugin' ),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'gag-tag' ),
    );

    register_taxonomy( 'gag_tag', array( 'gag' ), $args );
}
add_action( 'init', 'gags_taxonomies', 0 );

add_action( 'add_meta_boxes', 'add_gag_metaboxes' );

// Add the gag Meta Boxes
function add_gag_metaboxes() {
    add_meta_box('gag_custom_metabox', 'Gags Meta Fields', 'gag_custom_metabox', 'gag', 'normal', 'high');
}

// The gag Location Metabox

function gag_custom_metabox() {
    global $post;
    
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="gagmeta_noncename" id="gagmeta_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
    echo '<p>';
    // Get the img data if its already been entered
    $gag_img_url = get_post_meta($post->ID, '_gag_image_url', true);
    
    // Echo out the field
    echo '<label for="image">'.esc_html__('Gag Image Url','gags-plugin').'</label>';
    echo '<input type="text" name="_gag_image_url" value="' . $gag_img_url  . '" class="widefat" />';
    echo '</p>';

    echo '<p>';
    // Get the vid data if its already been entered
    $gag_vid_url = get_post_meta($post->ID, '_gag_video_embed_url', true);
    
    // Echo out the field
    echo '<label for="video">'.esc_html__('Gag Video Embed Url','gags-plugin').'</label>';
    echo '<input type="text" name="_gag_video_embed_url" value="' . $gag_vid_url  . '" class="widefat" />';
    echo '</p>';

    $custom = get_post_custom($post->ID);
    if( isset( $custom["_gag_nfsw"] ) ) {
        $gags_nsfw = $custom["_gag_nfsw"][0]; 
    } else {
        $gags_nsfw = '';
    }
?>
    <input type="checkbox" id="gag-nfsw" name="_gag_nfsw" <?php if( $gags_nsfw == true ) { ?> checked="checked"<?php } ?> /> <label for="gag-nfsw"><?php esc_html_e("NSFW - (Not Safe For Work)","gags-plugin"); ?></label>
<?php
}

// Save the Metabox Data

function wpt_save_gag_meta($post_id, $post) {
    
    // verify this came from the our screen and with proper authorization,

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    
    $gag_meta['_gag_image_url'] = (isset($_POST['_gag_image_url'])    ? $_POST['_gag_image_url']    : '');
    $gag_meta['_gag_video_embed_url'] = (isset($_POST['_gag_video_embed_url'])    ? $_POST['_gag_video_embed_url']    : '');
    $gag_meta['_gag_nfsw'] = (isset($_POST['_gag_nfsw'])    ? $_POST['_gag_nfsw']    : '');
    
    // Add values of $gag_meta as custom fields
    
    foreach ($gag_meta as $key => $value) { // Cycle through the $gag_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }

}

add_action('save_post', 'wpt_save_gag_meta', 1, 2); // save the custom fields
?>