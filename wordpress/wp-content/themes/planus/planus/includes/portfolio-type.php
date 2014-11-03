<?php

add_action('init', 'portfolio_register');  
   
function portfolio_register() {

	$labels = array(
		'name'               => _x( 'Leadership items', 'post type general name', 'planuswp' ),
		'singular_name'      => _x( 'Leadership item', 'post type singular name', 'planuswp' ),
		'menu_name'          => _x( 'Leadership items', 'admin menu', 'planuswp' ),
		'name_admin_bar'     => _x( 'Leadership items', 'add new on admin bar', 'planuswp' ),
		'add_new'            => _x( 'Add New', 'book', 'planuswp' ),
		'add_new_item'       => __( 'Add New Leadership item', 'planuswp' ),
		'new_item'           => __( 'New Leadership item', 'planuswp' ),
		'edit_item'          => __( 'Edit Leadership item', 'planuswp' ),
		'view_item'          => __( 'View Leadership item', 'planuswp' ),
		'all_items'          => __( 'All Leadership items', 'planuswp' ),
		'search_items'       => __( 'Search Leadership items', 'planuswp' ),
		'parent_item_colon'  => __( 'Parent Leadership item:', 'planuswp' ),
		'not_found'          => __( 'No Leadership items found.', 'planuswp' ),
		'not_found_in_trash' => __( 'No Leadership items found in Trash.', 'planuswp' ),
	);

	$args = array(  
		'labels'             => $labels,
		'public'             => true,
		'menu_icon'          => 'dashicons-portfolio',
		'show_ui'            => true,  
		'capability_type'    => 'post',  
		'hierarchical'       => false,  
		'rewrite'            => true,  
		'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields')  
	);  
   
	register_post_type( 'portfolio' , $args );  
}


// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_portfolio_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_portfolio_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Leadership Category', 'taxonomy general name' ),
		'singular_name'     => _x( 'Leadership Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Leadership Categories' ),
		'all_items'         => __( 'All Leadership Categories' ),
		'parent_item'       => __( 'Parent Leadership Category' ),
		'parent_item_colon' => __( 'Parent Leadership Category:' ),
		'edit_item'         => __( 'Edit Leadership Category' ),
		'update_item'       => __( 'Update Leadership Category' ),
		'add_new_item'      => __( 'Add New Leadership Category' ),
		'new_item_name'     => __( 'New Leadership Name' ),
		'menu_name'         => __( 'Leadership Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => true,
	);

	register_taxonomy( 'portfoliocats', array( 'portfolio' ), $args );
}

?>