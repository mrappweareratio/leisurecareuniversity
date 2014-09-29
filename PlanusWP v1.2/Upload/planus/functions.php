<?php

/* Include some external files */
include_once('includes/theme-setup.php');
include_once('includes/portfolio-type.php');
include_once('includes/testimonials-type.php');
include_once('includes/shortcodes.php');
include_once('includes/tinymce-plugins.php');

/* No HTML in comments */
add_filter( 'comment_text', 'wp_filter_nohtml_kses' );
add_filter( 'comment_text_rss', 'wp_filter_nohtml_kses' );
add_filter( 'comment_excerpt', 'wp_filter_nohtml_kses' );


/* Gets the home sections from their templates in certain order */
function get_home_sections() {
	if ( function_exists( 'ot_get_option' ) ) {
		$home_array = ot_get_option( 'sections' );
	}

	if (home_array != "") {
		foreach ($home_array as $key => $values) {
			if ($values['custom_page_section'] == '') {
				$home_section = array($values['choose_section']);
				foreach ($home_section as $choosen) {
					get_template_part( 'section', $choosen );
				}
			} else {
				$home_section = array($values['custom_page_section']);
				foreach ($home_section as $choosen) {
					$post = get_post($choosen);

					$content = $post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					
					$post_title = $post->post_title;
					$post_slug = $post->post_name;

					$background_arr = get_post_meta( $post->ID, 'custom_page_background', true );
					if ( function_exists( 'ot_get_option' ) && $background_arr !== "" ) {
						
						$color = $background_arr['background-color'];
						$image = $background_arr['background-image'];
						$position = $background_arr['background-position'];
						$attachment = $background_arr['background-attachment'];
						$repeat = $background_arr['background-repeat'];
						$size = $background_arr['background-size'];

						$background = '';

						if ($image) {
							$background .= "background:$color url($image) $attachment $position $repeat;\nbackground-size:$size;\n";
						} elseif ($background_arr['background-color']){
							$background .= "background-color:$color;\nbackground-image:none;\n";
						} else {
							return;
						}

					}

					if (function_exists( 'ot_get_option' )) {
						$content_color = 'color:'.get_post_meta( $post->ID, 'custom_page_content_color', true ).' !important;';
					}

					if (function_exists( 'ot_get_option' )) {
						$title_color = 'color:'.get_post_meta( $post->ID, 'custom_page_title_color', true ).' !important;';
					}

					if ($background == "" && $content_color == "") {
						$page_styles = "";
					} else {
						$page_styles = 'style="'.$background.' '.$content_color.'"';
					}

					echo '<section id="'.$post_slug.'" class="cbp-so-section custom-page-section" '.$page_styles.'>';
						echo '<div class="container cbp-so-side cbp-so-side-top">';
							echo '<h1 style="'.$title_color.'">'.$post_title.'</h1>';
							echo '<div class="post-content" style="'.$content_color.'">'.$content.'</div>';
						echo '</div>';
					echo '</section>';

				}
			}
		}
	}
}


/* This function creates the top menu items according to the sections from the home page */
function dynamic_menu() {
	if ( function_exists( 'ot_get_option' ) ) {
		$home_array = ot_get_option( 'sections' );
		foreach($home_array as $key => $value) { 
			if($value['section_title_menu'] == "") { 
				unset($home_array[$key]); 
			} 
		} 
		$new_array = array_values($home_array);

		// print_r($new_array);
	}

	$menuParams = array(
		'theme_location'  => 'home_menu',
		'menu'            => '',
		'container'       => false,
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => false,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);

	echo '<ul class="nav navbar-nav">';
	if ($new_array != "") {
		foreach ($new_array as $key => $values) {

			if ($values['custom_page_section'] !== "") {
				$id = array($values['custom_page_section']);
				$post = get_post($id[0]);
				$home_sections = array($post->post_name);
			} else {
				$home_sections = array($values['choose_section']);
			}

			// $home_sections = array($values['choose_section']);
			$menu_titles = array($values['section_title_menu']);

			foreach ($home_sections as $index => $choosen) {
				echo '<li><a href="#'.$choosen.'">'.$menu_titles[$index].'</a></li>';
			}

		}
	}
	if ( has_nav_menu( 'home_menu' ) ) {
		$menu = wp_nav_menu( $menuParams );
	}
	echo preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
	echo '</ul>';
}


/* Custom Bakcground for Welcome Screen */
function custom_bg_section( $section ) {

	if ( function_exists( 'ot_get_option' ) && ot_get_option( $section ) != '') {
		$background = ot_get_option( $section );
		$color = $background['background-color'];
		$image = $background['background-image'];
		$position = $background['background-position'];
		$attachment = $background['background-attachment'];
		$repeat = $background['background-repeat'];
		$size = $background['background-size'];
	}

	$output = '';

	if ($image) {
		$output .= "background:$color url($image) $attachment $position $repeat;\nbackground-size:$size;\n";
	} elseif ($background['background-color']){
		$output .= "background-color:$color;\nbackground-image:none;\n";
	} else {
		return;
	}

	if ($output <> '') {
		echo $output;
		}
}


/* Social icons */
function insertSocialIcons() {
	if ( function_exists( 'ot_get_option' ) ) {
		$social_icons = ot_get_option( 'insert_social_icons' );
	}

	echo "<div class=\"social-icons\">";
	if ($social_icons != "") {
		foreach ($social_icons as $key => $values) {
			$the_urls = array($values['profile_url']);
			$social_profile = array($values['social_profile']);
			$the_titles = array($values['title']);

			foreach ($the_urls as $index => $url) {
			echo "<a class=\"icon-social\" href=\"" . $url . "\" target=\"_blank\"><i class=\"fa " . $social_profile[$index] . "\"></i></a>";
			}
		}
	}
	echo "</div>";
}


/* Get categories for custom post types */
function get_the_category_bytax( $id = false, $tcat = 'category' ) {
	$categories = get_the_terms( $id, $tcat );
	if ( ! $categories )
		$categories = array();

	$categories = array_values( $categories );

	foreach ( array_keys( $categories ) as $key ) {
		_make_cat_compat( $categories[$key] );
	}

	// Filter name is plural because we return alot of categories (possibly more than #13237) not just one
	return apply_filters( 'get_the_categories', $categories );
}


/* Get the Post ID from attached image */
function custom_get_attachment_id( $guid ) {
	global $wpdb;

	/* nothing to find return false */
	if ( ! $guid )
		return false;

	/* get the ID */
	$id = $wpdb->get_var( $wpdb->prepare(
    "
	SELECT  p.ID
	FROM    $wpdb->posts p
	WHERE   p.guid = %s
	        AND p.post_type = %s
	",
	$guid,
	'attachment'
	) );

	/* the ID was not found, try getting it the expensive WordPress way */
	if ( $id == 0 )
		$id = url_to_postid( $guid );

	return $id;
}


/* Limit post excerpts. Within theme files used as print string_limit_words(get_the_excerpt(), 20); */
function string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}


/* Hide Url field on comments */
add_filter('comment_form_default_fields', 'planuswp_remove_url');
function planuswp_remove_url($arg) {
	$arg['url'] = '';
	return $arg;
}


/* Print the Comments. This is the function called from comments.php */
if ( ! function_exists( 'planuswp_comment' ) ) :

function planuswp_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php printf( __( '%s <span class="says">says:</span>', 'planuswp' ), sprintf( '<i class="fa fa-user"></i><cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->

			<div class="comment-meta commentmetadata">
				<?php
					$comm_date = get_comment_date('F jS, Y');
					echo '<span class="comment-date"><i class="fa fa-calendar"></i>'.$comm_date.'</span>';
					echo edit_comment_link( __( 'Edit comment', 'planuswp' ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation">
					<i class="fa fa-exclamation"></i>
					<?php _e( 'Your comment is awaiting moderation.', 'planuswp' ); ?>
				</em>
				<br />
			<?php endif; ?>

			<div class="comment-body"><?php comment_text(); ?></div>

		</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'planuswp' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'planuswp' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/* This function creates the pagination */
if ( ! function_exists( 'planuswp_pagination' ) ) :

function planuswp_pagination($pages = '', $range = 2)
{  
	$showitems = ($range * 2)+1;  

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
		 $pages = 1;
		}
	}

	if(1 != $pages) {
		echo "<div class='pagination'>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
		if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

		for ($i=1; $i <= $pages; $i++) { 
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
			}
		}

		if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
			echo "</div>\n";
		}
	}
	endif;



if ( ! function_exists( 'planuswp_post_nav' ) ) :

function planuswp_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'planuswp' ); ?></h1>
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'planuswp' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', 'planuswp' ) );
				next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', 'planuswp' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


/* Changing excerpt more text */
function new_excerpt_more($more) {
	global $post;
	return ' ... <a href="'. get_permalink($post->ID) . '">' . __( 'Read More &raquo;', 'planuswp' ) . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


/* Replace the logo on login form */
function replace_login_logo() { ?>
	<?php if ( function_exists( 'ot_get_option' ) ) {
		$logo = ot_get_option( 'logo_upload' );
	} ?>

	<?php if ( ! empty( $logo )) { ?>

    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo $logo; ?>);
            padding-bottom: 30px;
            -webkit-background-size: auto;
            background-size: auto;
            height: auto;
            width: auto;
        }
    </style>

    <?php } ?>

<?php }

add_action( 'login_enqueue_scripts', 'replace_login_logo' );



/* =============================================================================
	Include the Option-Tree Google Fonts Plugin
	========================================================================== */

// load the ot-google-fonts plugin if the loader class is available
if( class_exists( 'OT_Loader' ) ):

	global $ot_options;

	$ot_options = get_option( 'option_tree' );

	// default fonts used in this theme, even though there are no google fonts
	$default_theme_fonts = array(
		'arial' => 'Arial, Helvetica, sans-serif',
		'helvetica' => 'Helvetica, Arial, sans-serif',
		'georgia' => 'Georgia, "Times New Roman", Times, serif',
		'tahoma' => 'Tahoma, Geneva, sans-serif',
		'times' => '"Times New Roman", Times, serif',
		'trebuchet' => '"Trebuchet MS", Arial, Helvetica, sans-serif',
		'verdana' => 'Verdana, Geneva, sans-serif'
	);

	// $apikey = ot_get_option( 'fonts_api' );

	defined('OT_FONT_DEFAULTS') or define('OT_FONT_DEFAULTS', serialize($default_theme_fonts));
	defined('OT_FONT_API_KEY') or define('OT_FONT_API_KEY', 'AIzaSyBT5q7zWFGIqJC-xiQ_7-Q1FW4HC1dVGmw'); // enter your own Google Font API key here
	defined('OT_FONT_CACHE_INTERVAL') or define('OT_FONT_CACHE_INTERVAL', 0); // Checking once a week for new Fonts. The time interval for the remote XML cache in the database (21600 seconds = 6 hours)

	// get the OT-Google-Font plugin file
	include_once( get_template_directory().'/option-tree-google-fonts/ot-google-fonts.php' );

	// get the google font array - build in ot-google-fonts.php
	$google_font_array = ot_get_google_font(OT_FONT_API_KEY, OT_FONT_CACHE_INTERVAL);

	// Now apply the fonts to the font dropdowns in theme options with the build in OptionTree hook
	function ot_filter_recognized_font_families( $array, $field_id ) {

		global $google_font_array;

		// loop through the cached google font array if available and append to default fonts
		$font_array = array();
		if($google_font_array){
				foreach($google_font_array as $index => $value){
						$font_array[$index] = $value['family'];
				}
		}

		// put both arrays together
		$array = array_merge(unserialize(OT_FONT_DEFAULTS), $font_array);

		return $array;

	}
	add_filter( 'ot_recognized_font_families', 'ot_filter_recognized_font_families', 1, 2 );

endif;

remove_action( 'admin_notices', 'notice_new_fonts_added', 99);
remove_action( 'admin_notices', 'msg_no_connection_possible', 99);


?>