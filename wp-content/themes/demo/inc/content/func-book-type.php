<?php
/**
 * Register a post type
 */
function codex_custom_init() {
    $labels = array(
        'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Book', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Books', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
        'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
        'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
        'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'book' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'taxonomies'  => array( 'category' ),
        'supports' => array( 'title', 'editor', 'thumbnail'),
    );

    register_post_type( 'book', $args );
}
add_action( 'init', 'codex_custom_init' );

/**
 * Add meta box for edit page
 */
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add($postType)
{
    $types = array('post', 'book');
    if(in_array($postType, $types)){
        add_meta_box(
            'stick-key',
            'Demo Meta box',
            'cd_meta_box_cb',
            $postType,
            'normal'
        );
    }
}

function cd_meta_box_cb()
{
    global $post;
    $values = get_post_custom( $post->ID );
    $checked = isset( $values['stick-key'] ) ? $values['stick-key'] : 0;
    ?>
    <label for="my_meta_box_text">Text Label</label>
        <input type="checkbox" name="stick-key" id="stick-key" <?php echo ($checked) ? 'checked' : '' ?> />
    <?php
}

add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    $checked = isset( $_POST['stick-key'] ) && $_POST['stick-key'] ? 1 : 0;
    if( isset( $_POST['stick-key'] ) )
        update_post_meta( $post_id, 'stick-key', $checked );

}

/**
 * Start control filter
 */
/* Add stick for filter */
function display_posts_stickiness( $column, $post_id ) {
    if ($column == 'sticky'){
        $values = get_post_custom( $post_id );
        $checked = isset( $values['stick-key'][0] ) ? $values['stick-key'][0] : 0;
        echo '<input value="' . $post_id . '" class="target" type="checkbox" ', ( $checked ? ' checked' : ''), '/>';
    }
}
add_action( 'manage_posts_custom_column' , 'display_posts_stickiness', 10, 2 );

/* Add custom column to post list */
function add_sticky_column( $columns ) {
    unset($columns['comments']);
    return array_merge( $columns,
        array( 'sticky' => __( 'Sticky', 'your_text_domain' ) ) );
}
add_filter( 'manage_posts_columns' , 'add_sticky_column' );

function manage_sortable_columns( $columns )
{
    $columns['sticky'] = 'Sticky';
    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'manage_sortable_columns');

function enqueue_scripts_styles_init() {
    wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/js/script.js', array('jquery'), 1.0 ); // jQuery will be included automatically
    wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
}
add_action('init', 'enqueue_scripts_styles_init');

function ajax_action_stuff() {
    $post_id = $_POST['post_id']; // getting variables from ajax post
    $checked = $_POST['checked'];
    // doing ajax stuff
    update_post_meta($post_id, 'stick-key', $checked);
    echo 'ajax submitted'. $checked;
    die(); // stop executing script
}
add_action( 'wp_ajax_ajax_action', 'ajax_action_stuff' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_ajax_action', 'ajax_action_stuff' ); // ajax for not logged in users



/**
 * Add upload image
 */

add_action( 'add_meta_boxes', 'upload_meta_box_add' );
function upload_meta_box_add($postType)
{
    $types = array('post', 'book');
    if(in_array($postType, $types)){
        add_meta_box(
            'event_file',
            'Demo Upload Meta box',
            'swp_file_upload',
            $postType,
            'normal'
        );
    }
}
function swp_file_upload()
{
    global $post;
// Noncename needed to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';;
    global $wpdb;
    $strFile = get_post_meta( $post->ID, $key = 'event_file', $single = true );
    ?>
    <h2 class="media-upload"> Upload a file </h2>

    <script type="text/javascript">
        jQuery(document).ready(function(){

            jQuery('#upload_image_button').click(function()
            {
                formfield = jQuery(this).prev().attr('name');
                inp_id = jQuery(this).prev().attr('id');
                jQuery('#img_txt_id').val(inp_id);
                tb_show('', 'media-upload.php?post_id=<?php  echo $post->ID; ?>&type=image&amp;TB_iframe=true');
                return false;
            });

            window.send_to_editor = function(html) {
                img_cont = jQuery('#img_txt_id').val();
//console.log(html);
                var imgurl =jQuery(html).attr("href");
                jQuery('#'+img_cont).val(imgurl);
                tb_remove();
            };
        } ) ;
    </script>

    <div>
        <table>
            <tr valign="top">
                <td>
                    <input type="text" name="event_file" id="event_file" size="36" value="<?php echo $strFile; ?>" />
                    <input id="upload_image_button" type="button" value="Upload">
                </td>
            </tr>
        </table>
        <input type="hidden" name="img_txt_id" id="img_txt_id" value="" />
    </div>
    <?php
    function admin_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }

    function admin_styles()
    {
        wp_enqueue_style('thickbox');
    }

    add_action('admin_print_scripts', 'admin_scripts');
    add_action('admin_print_styles', 'admin_styles');
}

function save_events_meta($post_id, $post)
{
// verify this came from the our screen and with proper authorization,
// because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
    }
// Is the user allowed to edit the post?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
// We need to find and save the data
// We'll put it into an array to make it easier to loop though.
    $events_meta['event_file'] = $_POST['event_file'];
// Add values of $events_meta as custom fields

    foreach ($events_meta as $key => $value)
    {
        if( $post->post_type == 'revision' ) return;
        $value = implode(',', (array)$value);
        if(get_post_meta($post->ID, $key, FALSE))
        { // If the custom field already has a value it will update
            update_post_meta($post->ID, $key, $value);
        }
        else
        { // If the custom field doesn't have a value it will add
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank value
    }
}
add_action('save_post', 'save_events_meta', 1, 2); // save the custom fields