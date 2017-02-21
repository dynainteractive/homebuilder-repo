<?php
/*
 *  Author: Chris Campbell
 *  URL: dynainteractive.com
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

if( function_exists('acf_add_options_page') ) {
 
	$page = acf_add_options_page(array(
		'page_title' 	=> 'Global Elements',
		'menu_title' 	=> 'Global',
		'menu_slug' 	=> 'global-elements',
		'capability' 	=> 'edit_posts',
		'position' 		=> 40,
		'redirect' 		=> false
	));
    
   /* acf_add_options_sub_page(array(
		'page_title' 	=> 'Global Header',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'global-elements',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Global Footer',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'global-elements',
	));*/
 
}

function customorderby($orderby) {
    return 'mt1.meta_value, mt2.meta_value ASC';
}

// populate acf field (sample_field) with post types (sample_post_type)
function acf_load_sample_field( $field ) {
    $field['choices'] = get_post_type_values( 'communities' );
    return $field;
}
add_filter( 'acf/load_field/name=community_link', 'acf_load_sample_field' );
function get_post_type_values( $post_type ) {
    $values = array();
    $defaults = array(
                        'post_type' => $post_type,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    );
    $query = new WP_Query( $defaults );
    if ( $query->found_posts > 0 ) {
        foreach ( $query->posts as $post ) {
          $values[get_the_title( $post->ID )] = get_the_title( $post->ID );
        }
    }
    return $values;
}


/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 1000;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 900, '', true); // Large Thumbnail
    add_image_size('medium', 500, '', true); // Medium Thumbnail
    add_image_size('listing', 500, 330, true); // Listing Thumbnail
    add_image_size('main', 1200, 665, true); // Listing Thumbnail

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('custom', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/
function blog_title() 
{
	echo '<span>Home Builder</span>Blog';	
}


// Custom navigation
function nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="main-nav">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

function utl_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'extra-menu',
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="utl-nav">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load Custom scripts (header.php)
function header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
		wp_register_script('cycle', get_template_directory_uri() . '/js/jquery.cycle2.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('cycle'); // Enqueue it!
		
        wp_register_script('tinynav', get_template_directory_uri() . '/js/tinynav.min.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('tinynav'); // Enqueue it!
        
        wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('scripts'); // Enqueue it!
    }
}

// Load Custom conditional scripts
function conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load Custom styles
function styles()
{
    wp_register_style('base', get_template_directory_uri() . '/stylesheets/base.css', array(), '1.0', 'all');
    wp_enqueue_style('base'); // Enqueue it!

    wp_register_style('skeleton', get_template_directory_uri() . '/stylesheets/skeleton.css', array(), '1.0', 'all');
    wp_enqueue_style('skeleton'); // Enqueue it!
    
    wp_register_style('layout', get_template_directory_uri() . '/stylesheets/layout.css', array(), '1.0', 'all');
    wp_enqueue_style('layout'); // Enqueue it!
    
    wp_register_style('animate', get_template_directory_uri() . '/stylesheets/animate.css', array(), '1.0', 'all');
    wp_enqueue_style('animate'); // Enqueue it!
}

// Register Custom Navigation
function register_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'custom'), // Main Navigation
        'extra-menu' => __('Extra Menu', 'custom') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('General Sidebar', 'custom'),
        'description' => __('Only shown on general content pages', 'custom'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'name' => __('Blog Sidebar', 'custom'),
        'description' => __('Only shown on blog pages', 'custom'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function alt_wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function alt_wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using alt_wp_excerpt('alt_wp_index');
{
    return 25;
}

// Create 40 Word Callback for Custom Post Excerpts, call using alt_wp_excerpt('alt_wp_custom_post');
function alt_wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function alt_wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('Read More &raquo;', 'custom') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function custom_gravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function custom_comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'styles'); // Add Theme Stylesheet
add_action('init', 'register_menu'); // Add Custom Menu
add_action('init', 'create_post_type_communities'); // Add our Communities Custom Post Type
add_action('init', 'create_post_type_floorplans'); // Add our Floor Plans Custom Post Type
add_action('init', 'create_post_type_homes'); // Add our Available Homes Custom Post Type
add_action('init', 'create_post_type_gallery'); // Add our Available Homes Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'alt_wp_pagination'); // Add our Custom Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'custom_gravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('shortcode_demo', 'shortcode_demo'); // You can place [shortcode_demo] in Pages, Posts now.
add_shortcode('shortcode_demo_2', 'shortcode_demo_2'); // Place [shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [shortcode_demo] [shortcode_demo_2] Here's the page title! [/shortcode_demo_2] [/shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for Communities
function create_post_type_communities()
{
    //register_taxonomy_for_object_type('category', 'communities'); // Register Taxonomies for Category
    //register_taxonomy_for_object_type('post_tag', 'communities');
    register_post_type('communities', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Communities', 'communities'), // Rename these to suit
            'singular_name' => __('Communities', 'communities'),
            'add_new' => __('Add New', 'communities'),
            'add_new_item' => __('Add New Community', 'communities'),
            'edit' => __('Edit', 'communities'),
            'edit_item' => __('Edit Community', 'communities'),
            'new_item' => __('New Community', 'communities'),
            'view' => __('View Community', 'communities'),
            'view_item' => __('View Community', 'communities'),
            'search_items' => __('Search Communities', 'communities'),
            'not_found' => __('No Communities found', 'communities'),
            'not_found_in_trash' => __('No Communities found in Trash', 'communities')
        ),
        'rewrite' => array('slug' => 'new-home-communities'),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(

        ) // Add Category and Post Tags support
    ));
}

// Create 1 Custom Post type for Floor Plans
function create_post_type_floorplans()
{
    //register_taxonomy_for_object_type('category', 'floorplans'); // Register Taxonomies for Category
    //register_taxonomy_for_object_type('post_tag', 'floorplans');
    register_post_type('floorplans', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Floor Plans', 'floorplans'), // Rename these to suit
            'singular_name' => __('Floor Plans', 'floorplans'),
            'add_new' => __('Add New', 'floorplans'),
            'add_new_item' => __('Add New Floor Plan', 'floorplans'),
            'edit' => __('Edit', 'floorplans'),
            'edit_item' => __('Edit Floor Plan', 'floorplans'),
            'new_item' => __('New Floor Plan', 'floorplans'),
            'view' => __('View Floor Plan', 'floorplans'),
            'view_item' => __('View Floor Plan', 'floorplans'),
            'search_items' => __('Search Floor Plans', 'floorplans'),
            'not_found' => __('No Floor Plans found', 'floorplans'),
            'not_found_in_trash' => __('No Floor Plans found in Trash', 'floorplans')
        ),
        'rewrite' => array('slug' => 'home-builder-plans'),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(

        ) // Add Category and Post Tags support
    ));
}

// Create 1 Custom Post type for Homes
function create_post_type_homes()
{
    //register_taxonomy_for_object_type('category', 'homes'); // Register Taxonomies for Category
    //register_taxonomy_for_object_type('post_tag', 'homes');
    register_post_type('homes', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Available Homes', 'models'), // Rename these to suit
            'singular_name' => __('Available Homes', 'models'),
            'add_new' => __('Add New', 'models'),
            'add_new_item' => __('Add New Available Home', 'models'),
            'edit' => __('Edit', 'models'),
            'edit_item' => __('Edit Available Home', 'models'),
            'new_item' => __('New Available Home', 'models'),
            'view' => __('View Available Home', 'models'),
            'view_item' => __('View Available Home', 'models'),
            'search_items' => __('Search Available Homes', 'models'),
            'not_found' => __('No Available Homes found', 'models'),
            'not_found_in_trash' => __('No Available Homes found in Trash', 'models')
        ),
        'rewrite' => array('slug' => 'new-homes-for-sale'),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(

        ) // Add Category and Post Tags support
    ));
}

// Create 1 Custom Post type for Photos
function create_post_type_gallery()
{
    register_taxonomy_for_object_type('category', 'gallery'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'gallery');
    register_post_type('gallery', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Photo Gallery', 'gallery'), // Rename these to suit
            'singular_name' => __('Photo Gallery', 'gallery'),
            'add_new' => __('Add New', 'gallery'),
            'add_new_item' => __('Add New Photo Gallery', 'gallery'),
            'edit' => __('Edit', 'gallery'),
            'edit_item' => __('Edit Photo Gallery', 'gallery'),
            'new_item' => __('New Photo Gallery', 'gallery'),
            'view' => __('View Photo Gallery', 'gallery'),
            'view_item' => __('View Photo Gallery', 'gallery'),
            'search_items' => __('Search Photo Galleries', 'gallery'),
            'not_found' => __('No Photo Gallery found', 'gallery'),
            'not_found_in_trash' => __('No Photo Galleries found in Trash', 'gallery')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}


/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}


//Making jQuery Google API
function modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, '1.11.1');
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');

//Hide Author Names
add_action(‘template_redirect’, ‘bwp_template_redirect’);
function bwp_template_redirect() {
	if (is_author()) {
		wp_redirect( home_url() ); exit;
	}
}


//Making Homebuilder Icons
function add_menu_icons_styles(){
?>

<style>
#adminmenu #menu-posts-communities div.wp-menu-image:before { content: "\f231"; }
#adminmenu #menu-posts-floorplans div.wp-menu-image:before { content: "\f128"; }
#adminmenu #menu-posts-homes div.wp-menu-image:before { content: "\f102"; }
#adminmenu #menu-posts-models div.wp-menu-image:before { content: "\f230"; }
#adminmenu #menu-posts-gallery div.wp-menu-image:before { content: "\f306"; }
#adminmenu .toplevel_page_global-elements div.wp-menu-image:before { content: "\f319"; }
</style>

<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );


//TURN OFF CORNERSTONE STYLES
/*add_filter( 'cornerstone_customizer_output', '__return_false' );
add_filter( 'cornerstone_use_customizer', '__return_false' );*/

?>
