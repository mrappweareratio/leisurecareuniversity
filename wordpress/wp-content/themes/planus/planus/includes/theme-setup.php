<?php


/* Theme setup */
if ( ! function_exists( 'planuswp_setup' ) ) :
function planuswp_setup() {


	// Make Planuswp available for translation.
	load_theme_textdomain( 'planuswp', get_template_directory() . '/languages' );


	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );


	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' ); // This feature enables post-thumbnail support for a theme
    set_post_thumbnail_size( 260, 320, true ); // Normal post thumbnails
    add_image_size( 'excerpt-thumbnail', 750, 280, true ); // The image size for the first image in each post
    add_image_size( 'portfolio-thumbnail', 750, 440, true ); // The image size for the first image in each post
    

    // Image sizes
	update_option('thumbnail_size_w', 152);
	update_option('thumbnail_size_h', 152);
	update_option('thumbnail_crop', 1);
	update_option('medium_size_w', 750);
	update_option('medium_size_h', 440);
	update_option('large_size_w', 1140);
	update_option('large_size_h', 855);


	// This theme uses wp_nav_menu() in two locations.
	// Please note that the home page menu is just for additional links on menu as the links are generated automaticaly.
	register_nav_menus( array(
		'home_menu'   => __( 'Home Page Menu', 'planuswp' ),
		'primary'   => __( 'Inner Pages Menu', 'planuswp' ),
	) );

}
endif; // planuswp_setup
add_action( 'after_setup_theme', 'planuswp_setup' );


/* Option Tree setup */

// Meta Boxes
load_template( trailingslashit( get_template_directory() ) . 'includes/meta-boxes.php' );

// Required: set 'ot_theme_mode' filter to true.
add_filter( 'ot_theme_mode', '__return_true' );

// Required: include OptionTree.
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

// Theme Options
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );

// Show Settings Import
add_filter( 'ot_show_settings_import', '__return_false' );
add_filter( 'ot_show_options_ui', '__return_false' );
add_filter( 'ot_show_settings_export', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_show_docs', '__return_false' );

// Theme Style Option Tree - disable UI builder
add_filter( 'ot_show_pages', '__return_false' );

// Change Option Tree Header
add_filter('ot_header_version_text', 'option_tree_custom_title');
function option_tree_custom_title() {
	return 'PlanusWP Options Page - Powered by Option Tree';
}
add_filter('ot_header_logo_link', 'option_tree_remove_logo');
function option_tree_remove_logo() {
	return '';
}
add_filter('ot_upload_text', 'option_tree_custom_upload');
function option_tree_custom_upload() {
	return 'Send to field';
}

// Show only font selection field for typography fields on Theme Options
function filter_typography_fields( $array, $field_id ) {
	$heading_ids = array('heading_one_font', 'heading_two_font', 'heading_three_font', 'heading_four_font', 'heading_five_font', 'welcome_heading_one');
	if ( $field_id == "body_font" || $field_id == "menu_font") {
		$array = array( 'font-family', 'font-size');
	} else if ( in_array($field_id, $heading_ids) ) {
		$array = array( 'font-family', 'font-size', 'font-weight', 'letter-spacing', 'text-decoration', 'text-transform');
	}

	return $array;

}
add_filter( 'ot_recognized_typography_fields', 'filter_typography_fields', 10, 2 );


// Modify List Item Label to be more user friendly
function change_ot_list_item_label( $list_label, $list_id ) {
   if ( "sections" == $list_id ) {
      $list_label = __('Name your section', 'planuswp');
   }
   return $list_label;
}
add_filter( 'ot_list_item_title_label', 'change_ot_list_item_label', 10, 2 );

// Modify List Item Label to be more user friendly
function change_ot_list_item_description( $list_label, $list_id ) {
   if ( "sections" == $list_id ) {
      $list_label = __('Fill this field only for your information. The value will not be visible on front-end.', 'planuswp');
   }
   return $list_label;
}
add_filter( 'ot_list_item_title_desc', 'change_ot_list_item_description', 10, 2 );



/* Enqueues scripts and styles for front end. */
function planus_scripts_styles() {

	wp_register_script('googlemaps', ('http://maps.google.com/maps/api/js?sensor=false'), false, null, true);

	// Loads Javascript files.
	wp_enqueue_script('jquery', get_template_directory_uri() . 'http://code.jquery.com/jquery-latest.min.js', array(), null, true );
	wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'),'4.0.3', true );
	wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom.49276.js', array('jquery'),'3.0.0', true );
	wp_enqueue_script('cslider', get_template_directory_uri() . '/js/jquery.cslider.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'),'1.3', true );
	wp_enqueue_script('mixitup', get_template_directory_uri() . '/js/jquery.mixitup.js', array('jquery'),'1.5.4', true );
	wp_enqueue_script('prettyphotojs', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'),'3.1.5', true );
	wp_enqueue_script('cbpscroller', get_template_directory_uri() . '/js/cbpScroller.js', array('jquery'),'1.0.0', true );
	wp_enqueue_script('bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'),'4.1.1', true );
	wp_enqueue_script('classiejs', get_template_directory_uri() . '/js/classie.js', '1.0.0', true );
	wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'),'1.0', true );
	wp_enqueue_script('googlemaps');

	// Loads CSS files.
	wp_enqueue_style('fontawesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css', array(), null, false);
	// wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/bootstrap.css', array(), null, false);
	// wp_enqueue_style('bxslider', get_stylesheet_directory_uri() . '/bxslider.css', array(), null, false);
	// wp_enqueue_style('da-slider', get_stylesheet_directory_uri() . '/da-slider.css', array(), null, false);
	// wp_enqueue_style('prettyphoto', get_stylesheet_directory_uri() . '/prettyPhoto.css', array(), null, false);
	// wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css', array(), null, false);
	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css', false, '1.0');
}
add_action('wp_enqueue_scripts', 'planus_scripts_styles');


/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

} /* end bones head cleanup */

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

?>